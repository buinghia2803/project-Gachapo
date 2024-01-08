/**
 * List of number record in one page
 */
 export const PAGE_SIZES = [10, 20, 50, 100, 200, 500, 1000]

 /**
  * Number record in one page
  */
 export const DEFAULT_PAGE_SIZE = 10

 /**
  * Max number record return by api
  */
 export const MAX_LIMIT_RECORD = 1000

 /**
  * Minisecond
  */
 export const MINISECOND = 1000

 /**
  * Sort type
  */
 export const SORT_TYPE = {
   DESC: 0,
   ASC: 1
 }

 export const MAX_RECORD_GACHA_HOME = 10
/*
|--------------------------------------------------------------------------------
| CONST OF USER
|--------------------------------------------------------------------------------
*/
export const ADDRESS_TYPE_SECOND = 2

export const OPTION_CATEGORIES = [
  { id: 1, text: 'キャラクター・コンテンツ', value: '1'},
  { id: 2, text: 'ミュージシャン', value: '2'},
  { id: 3, text: 'アイドル', value: '3'},
  { id: 4, text: 'タレント', value: '4'},
  { id: 5, text: 'アニメ', value: '5'},
  { id: 6, text: 'ホビー', value: '6'},
  { id: 7, text: 'それ以外', value: '7'},
]

export const OPTION_ADDRESS_TYPES = [
  {id: 1, value: 1, text: '住所1に届ける '},
  {id: 2, value: 2, text: '住所2に届ける '}
]
export const OPTION_GENDER = [
  {id: 1, value: 1, text: '男性'},
  {id: 2, value: 2, text: '女性'},
  {id: 3, value: 3, text: 'その他'}
]
export const LIMIT_HISTORY_GACHA = 5

export const LIMIT_LIST_ORDER = 7

export const STATUS_DELIVERED = 3

export const LIST_STATUS_GACHA = [
  {id: 1, name: '稼働中'},
  {id: 2, name: '停止中'},
  {id: 3, name: '販売終了'},
]

export const LIST_STATUS_ORDER_HISTORY = [
  {id: 1, name: '未発送'},
  {id: 2, name: '配送中'},
  {id: 3, name: '発送'},
  {id: 4, name: 'キャンセル'},
]

export const LIST_STATUS_FAVORITE_GACHA = [
  {id: 1, name: ' 販売中'},
  {id: 2, name: ' 停止中'},
]
