<?php


namespace App\Repositories;


use App\Models\Gacha;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class GachaRepository extends BaseRepository
{
    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Gacha::class;
    }

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where('gachas.id', $data);
                break;
            case 'status':
                return $query->where('gachas.status', $data);
                break;
            case 'category_id':
            case 'company_id':
            case 'start_time':
            case 'recommend':
            case 'status_apply_discounts':
                return $query->where($column, $data);
                break;
            case 'status_operation':
                $currenTime = date('Y-m-d H:i:s');
                if ($data == GACHA_OPERATION_STOP_SALE) {
                    return $query->where(function ($query) use ($currenTime) {
                        $query->where('period_start', '>', $currenTime)->orWhere('period_end', '<', $currenTime);
                    });
                } elseif ($data == 'stop') {
                    return $query->where($column, 0)->where(function ($query) use ($currenTime) {
                        $query->where('period_start', '<', $currenTime)->where('period_end', '>', $currenTime);
                    });
                } else {
                    return $query->where($column, $data)->where(function ($query) use ($currenTime) {
                        $query->where('period_start', '<', $currenTime)->where('period_end', '>', $currenTime);
                    });
                }
                break;
            case 'name':
            case 'description':
                return $query->where($column, 'like', '%' . $data . '%');
            case 'keyword':
                return $query->leftjoin('products', 'gachas.id', 'products.gacha_id')
                    ->orWhereRaw("( gachas.name like '%" . $data . "%' or gachas.description like '%" . $data . "%' or products.name like '%" . $data . "%' )")
                    ->select('gachas.*');
                break;
            case 'company_name':
                return $query->join('companies', 'gachas.company_id', 'companies.id')
                    ->where('companies.company', 'like', '%' . $data . '%')
                    ->select('gachas.*');
                break;
            case 'price_types':
                if (!is_array($data)) {
                    if (is_array(json_decode($data))) {
                        $data = json_decode($data);
                    } else {
                        throw new \Exception("$column isn't array!");
                    }
                }

                foreach ($data as $key => $value) {
                    if ($value) {
                        $range = PRICE_TYPES[$value];

                        if (isset($range['to'])) {
                            if (!$key) {
                                $query->whereRaw("(`selling_price` between " . $range['from'] . ' and ' . $range['to'] . ($key == count($data) - 1 ? ')' : ''));
                            } else {
                                $query->orWhereRaw("`selling_price` between " . $range['from'] . ' and ' . $range['to'] . ($key == count($data) - 1 ? ')' : ''));
                            }
                        } else {
                            if (!$key) {
                                $query->where('selling_price', '>', $range['from']);
                            } else {
                                $query->orWhereRaw('selling_price > ' . $range['from'] . ($key == count($data) - 1 ? ')' : ''));
                            }
                        }
                    }
                }

                return $query;
            case 'category_ids':
                if (!is_array($data)) {
                    if (is_array(json_decode($data))) {
                        $data = json_decode($data);
                    } else {
                        throw new \Exception("$column isn't array!");
                    }
                }

                return $query->whereIn('category_id', $data);
            case 'ids':
                if (!is_array($data)) {
                    throw new \Exception("$column isn't array!");
                }

                return $query->whereIn('id', $data);
            case 'created_at':
                $startDate = Carbon::today()->subDays(RANGE_DAY_ARRIVAL_GACHA)->toDateString();
                $endDate = Carbon::today()->toDateString();

                return $query->whereBetween($column, [$startDate, $endDate]);
            case 'period_start':
                $startDate = Carbon::today()->subDays(RANGE_DAY_ARRIVAL_GACHA)->toDateString();
                $endDate = Carbon::today()->toDateString();

                return $query->whereBetween($column, [$startDate, $endDate]);
            case 'order_by':
                return $query->orderBy($data['fields'], $data['sort_type']);
            case 'id_history':
                if (!is_array($data)) {
                    throw new \Exception("$column isn't array!");
                }

                return $query->whereIn('id', $data)->with(['products', 'images' => function ($q) {
                    return $q->orderBy('created_at', 'DESC');
                }]);
            case 'type':
                $startDate = Carbon::today()->subDays(RANGE_DAY_ARRIVAL_GACHA)->toDateString();
                $endDate = Carbon::today()->toDateString();
                switch ((int)$data) {
                    case RECOMMEND_TYPE:
                        $query->whereBetween('created_at', [$startDate, $endDate])->where('recommend', RECOMMEND_TYPE);
                        break;
                    case FAVORITE_TYPE:
                        $query->whereBetween('created_at', [$startDate, $endDate])->withCount('orders');
                        break;
                    case NEW_TYPE:
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                        break;
                }

                return $query;
            default:
                return $query;
                break;
        }
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    /**
     * Event user like gacha.
     * @param array $conds
     *
     * @return boolean
     */
    public function eventLikeGacha($conds)
    {
        $gacha = Gacha::find($conds['gacha_id']);
        if ($gacha) {
            $result = $gacha->users()->syncWithoutDetaching([$conds['user_id']]);
            if (isset($result['attached']) && $result['attached']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Event user like gacha.
     * @param array $conds
     *
     * @return boolean
     */
    public function eventUnLikeGacha($conds)
    {
        $gacha = Gacha::find($conds['gacha_id']);
        if ($gacha) {
            $result = $gacha->users()->detach($conds['user_id']);
            if (isset($result['detached']) && $result['detached']) {
                return true;
            }
        }

        return false;
    }

    /**
     * get gacha by Ids
     *
     */
    public function getGachaByIds($gachaIds, $startTime, $endTime)
    {
        return  Gacha::query()
            ->join('orders', 'orders.gacha_id', 'gachas.id')
            ->whereIn('gachas.id', $gachaIds)
            ->whereDate('orders.created_at', '>=', $startTime)
            ->whereDate('orders.created_at', '<=', $endTime)
            ->select('gachas.*')
            ->groupBy('gachas.id')
            ->with([
                'orders' => function ($query) use ($startTime, $endTime) {
                    $query->whereDate('created_at', '>=', $startTime)
                        ->whereDate('created_at', '<=', $endTime);
                }
            ])
            ->get();
    }
}
