<?php

namespace App\Http\Controllers\Company;

use App\Business\ReviewBusiness;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Review\ReviewDetailRequest;
use App\Jobs\SendMailTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    protected ReviewBusiness $reviewBusiness;

    public function __construct(ReviewBusiness $reviewBusiness)
    {
        $this->reviewBusiness = $reviewBusiness;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Request
     */
    public function index(Request $request)
    {
        $dataCondition = [
            'limit' => 3
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);
        $param = $request->all();

        $reviews = $this->reviewBusiness->list($dataCondition, ['order.user']);

        return  view('company.review.index', compact('param', 'reviews'));
    }

    /**
     * Return tr tag for table
     *
     * @return \Illuminate\Http\Request
     */
    public function loadMore(Request $request)
    {
        $reviews = $this->reviewBusiness->loadMore($request->page);

        if ($request->ajax()) {
            $view = view('company.review.data', compact('reviews'))->render();

            return response()->json(['html' => $view]);
        }

        return response()->json(['html' => null]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $reviews = $this->reviewBusiness->getReviewDetail($id);

        return view('company.review.detail', compact('reviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewDetailRequest $request, $id)
    {
        try {
            $reviews = $this->reviewBusiness->getReviewDetail($id);

            $data = [
                'status' => 2,
                'order_id' => $reviews->order_id,
                'content'  => $reviews->content,
                'rating'  => $reviews->rating,
                'date_reply' => Carbon::now()
            ];

            $data = array_merge($request->all(), $data);
            // dd()

            $email = 'admin@example.com';

            SendMailTemplate::dispatch(MAIL_TEMPLATES_REPLY_REVIEW, $email, [
                'name_product'  => $reviews->product_name,
                'attachment' => $reviews->attachment,
                'rating'  => $reviews->rating,
                'content' => $reviews->content,
                'content_reply' => $reviews->content_reply
            ]);

            $this->reviewBusiness->updateReview($id, $data);

            return redirect()->route('company.review.show')->with([
                'success'   => __('messages.CM001_L005')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('company.review.show')->with([
                'error' => __('messages.CT_MSG010'),
            ]);
        }
    }
}
