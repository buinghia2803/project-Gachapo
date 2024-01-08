<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Coupon\CreateRequest;
use App\Http\Requests\Admin\Coupon\UpdateRequest;
use App\Http\Controllers\Controller;
use App\Business\CouponBusiness;
use App\Business\UserBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Jobs\CreateCoupon;

class CouponController extends Controller
{
    protected CouponBusiness $couponBusiness;
    protected UserBusiness $userBusiness;

    public function __construct(
        CouponBusiness $couponBusiness,
        UserBusiness $userBusiness
    )
    {
        $this->couponBusiness = $couponBusiness;
        $this->userBusiness = $userBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition = [
            'limit' => COUPON_PER_PAGE,
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);

        $coupons = $this->couponBusiness->list($dataCondition);
        $params = $request->all();
        if ($coupons->currentPage() > $lastPage = $coupons->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('admin.coupon.index', compact('params'));
        }

        return view('admin.coupon.index', compact('coupons', 'params'));
    }

    /**
     * Generate a code for coupon.
     */
    public function generateCouponCode()
    {
        try {
            $result = $this->couponBusiness->generateCouponCode();

            return response()->json([
                'data' => $result,
                'status' => self::CODE_SUCCESS_200,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], self::CODE_ERROR_400);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.coupon.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $newCoupon = $this->couponBusiness->create($request->all());
        if ($newCoupon) {
            $users = $this->userBusiness->findByCondition([])->get();
            foreach ($users as $user) {
                CreateCoupon::dispatch($user->email, $newCoupon);
            }

            return redirect()->route('admin.coupon.index')->with([
                'success' => __('messages.CT_MSG011'),
            ]);
        }

        return redirect()->route('admin.coupon.index')->with([
            'error' => __('messages.CT_MSG009'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = $this->couponBusiness->findById($id);

        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if ($this->couponBusiness->update($id, $request->all())) {
            return redirect()->route('admin.coupon.index')->with([
                'success' => __('messages.CM001_L006'),
            ]);
        }

        return redirect()->route('admin.coupon.index')->with([
            'error' => __('messages.AUTH001_MSG002'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($this->couponBusiness->delete($id)) {
                Session::put('deleted_success', true);

                return response()->json('success', 200);
            } else {
                Session::put('deleted_failed', true);
                return response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            Session::put('deleted_failed', true);
            \Log::error($e);
            return response()->json('failure', 400);
        }
    }
}
