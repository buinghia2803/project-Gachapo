<?php

const STATUS_SUCCESS = 200;
const STATUS_ERROR = 500;
const STATUS_400 = 400;

const ROLE_ADMIN = 'admin';
const ROLE_ADMIN_API = 'admin_api';
const ROLE_USER = 'user';
const ROLE_COMPANY = 'company';
const EXPIRE_TIME_SECRET_KEY = 24 * 30 * 60;
const SECRET_KEY_AES_256_CBC = 'WrNVKgjJFhZzHhRzoVpzK1fiqY1oev9FgheOe5YE';
const SECRET_IV_AES_256_CBC = 'irnluplAdGKHMWtTGgtjwpqCmiuYFQFA2xwSkYk8';
const ENCRYPT = 'encrypt';
const DECRYPT = 'decrypt';
const EXPIRED_MAIL_VERIFICATION_REGISTER = 24; // 24h
const EXPIRED_2ND_FACTOR = 15; // 15 minute
const TOKEN_EXPIRED = 24; // 24 hours

// common
const ASC = 'asc';
const DESC = 'desc';

// Image size default
const DEFAULT_WIDTH = 800;
const DEFAULT_HEIGHT = 600;
const DEFAULT_THUMB_WIDTH = 150;
const DEFAULT_THUMB_HEIGHT = 90;

// Page number default
const DEFAULT_PER_PAGE = 10;
const CATEGORY_PER_PAGE = 7;
const NOTIFY_PER_PAGE = 6;
const ADMIN_PER_PAGE = 7;
const COMPANY_PER_PAGE = 7;
const COMPANY_DASHBOARD_PER_PAGE = 5;
const USER_PER_PAGE = 7;
const STATIC_PAGE_PER_PAGE = 7;
const GACHA_PER_PAGE = 7;
const DELIVERY_PER_PAGE = 7;
const GACHA_CONFIRM_PRODUCT_PER_PAGE = 4;
const ANALYTIC_GACHA_PER_PAGE = 5;
const ANALYTIC_COMPANY_PER_PAGE = 5;
const ANALYTIC_DETAIL_PER_PAGE = 7;
const COUPON_PER_PAGE = 6;

// Extension language file
const XLSX_EXTENSION = '.xlsx';

// User constant
const SET_NOT_AVATAR = 0;
const SET_AS_AVATAR = 1;
const USER_IMAGE_TYPE = 1;
const PRODUCT_IMAGE_TYPE = 2;

// Mail templates info
const MAIL_TEMPLATES_REGISTRATION = 1;
const MAIL_TEMPLATES_COMPLETED_MEMBERSHIP_REGISTRATION = 2;
const MAIL_TEMPLATES_PASSWORD_RESET = 3;
const MAIL_TEMPLATES_NOTIFICATION_OF_RESERVATION_COMPLETION = 4;
const MAIL_TEMPLATES_TEMPORARY_REGISTRATION_OF_COMPANY = 5;
const MAIL_TEMPLATES_REPLY_REVIEW = 6;
const MAIL_TEMPLATES_APPROVE_THE_COMPANY = 7;
const MAIL_TEMPLATES_DISAPPROVE_THE_COMPANY = 8;
const MAIL_TEMPLATES_WITHDRAWAL = 9;
const MAIL_TEMPLATES_DELIVERY = 10;
const MAIL_TEMPLATES_RESERVATION_CANCELLATION_NOTICE = 11;
const MAIL_TEMPLATES_REGISTER_CONTACT = 12;
const SESSION_TEMPLATE_MAIL_TAB = 'session_template_mail_tab';

// Queue Job
const QUEUE_SEND_EMAIL_TEMPLATE = 'queue-send-mail-template';

// Banner
const BANNER_MAX_IN_LIST = 4;
const BANNER_TYPE_RANDOM = 'random';
const BANNER_TYPE_DEFAULT = 'default';
const BANNER_MAIN_VISUAL = 1;
const BANNER_NORMAL = 2;

// Notification status
const PUBLISH = 1; //publish/公開
const UNPUBLISH = 2; //unpublish/非公開

const USER = 1; // user/個人向け
const COMPANY = 2;  // company/企業向け

// Company And User status
const DEACTIVATE = 1;
const ACTIVE = 2;
const BLACKLIST = 3;
const WITHDRAWAL = 4;
const COMPANY_WAITING_APPROVED = 1;
const COMPANY_DISAPPROVED = 2;
const COMPANY_APPROVED = 3;
const NOTIFICATION_TYPE_USER = 1;
const DEFAULT_STATUS_COMPANY = 0;
const TWO_MONTH_WITHDRAW = 60; // 60 days
const STATUS_TWO_STEP_VERIFICATION = 1;

// Banner types.
const LIMIT_BANNER = 2;
const BANNER_TYPES = [
  'visual' => 1,
  'banner' => 2
];
const BANNER_TYPES_INVERS = [
  1 => 'visual',
  2 => 'banner'
];
const SHOW_TYPES = [
  'random' => 1,
  'desc' => 2
];
const SHOW_TYPE_RANDOM = 'random';

// Gacha
const RANGE_DAY_ARRIVAL_GACHA = 7;
const HOME_GACHA_LIMIT = 10;
const DEFAULT_TIME_SHIPMENT = 7; // 7 days
const DEFAULT_STATUS_DELIVERY = 1;
const ADDRESS_TYPE_FIRST = 1;
const GACHA_PENDING = 1;
const GACHA_APPROVED = 2;
const GACHA_DISAPPROVED = 3;
const GACHA_DRAF = 4;

const RECOMMEND_TYPE = 1;
const FAVORITE_TYPE = 2;
const NEW_TYPE = 3;


const GACHA_RECOMMEND_FALSE = 0;
const GACHA_RECOMMEND_TRUE = 1;

const GACHA_APPLY_DISCOUNT = 1;
const GACHA_NOT_APPLY_DISCOUNT = 2;

const GACHA_OPERATION_WORK = 1;
const GACHA_OPERATION_STOP = 0;
const GACHA_OPERATION_STOP_SALE = 2;

// Product
const PRODUCT_STATUS_ACTIVE = 1;
const PRODUCT_STATUS_DRAF = 2;
const PRODUCT_REWARD_PERCENTAGE = 1;
const PRODUCT_REWARD_INVENTORY = 2;
const PRODUCT_REWARD_NONE = 3;

const REWARD_TYPE = 'reward_type';
const REWARD_PERCENT = 'reward_percent';

// const PRICE_TYPES = [
//   1 => [0, 1000], //'０～１０００',
//   2 => [1001, 2500], // '１００１～２５００',
//   3 => [2501, 5000], //'２５０１～５０００',
//   4 => [5001, 10000], //'５００１～１００００',
//   5 => 10001, // '１０００１～'
// ];
const PRICE_TYPES = [
  1 => ['from' => 0, 'to' => 1000],
  2 => ['from' => 1001, 'to' => 2500],
  3 => ['from' => 2501, 'to' => 5000],
  4 => ['from' => 5001, 'to' => 10000],
  5 => ['from' => 10001],
];

const PRICE_TYPE_MORE_10001 = 5;

const REWARD_STATUS_QUANTITY = 2;

// Post status
const PUBLISH_POST = 1; //publish/公開
const UNPUBLISH_POST = 2; //unpublish/非公開
const DRAFT_POST = 3; //draft/下書き

// Post type
const PRIVACY_POLICY_REGISTRATION = 1; //プライバシーポリシー登録
const NOTATION_REGISTRATION_COMMERCIAL = 2; //特定商取引に関する表記登録
const TERMS_OF_USE_REGISTRATION = 3; // 利用規約登録
const NOTATION_REGISTRATION_SETTLEMENT = 4; // 資金決済法に関する表記登録
const COMPLIANCE_POLICY_REGISTRATION = 5; // コンプライアンスポリシー登録
const OPERATOR_INFORMATION = 6; // 運営者情報
const USAGE_GUIDE = 7; // 利用ガイド
const SHIPPING_CHARGES_INFO = 8; // 配送料と配送情報

// Analytic
const ANALYTIC_DEFAULT = 'default';
const ANALYTIC_CATEGORY = 'category';
const ANALYTIC_GACHA = 'gacha';
const ANALYTIC_COMPANY = 'company';

// Response types for user.
const RESPONSE_PROFILE = 1;
const RESPONSE_PASSWORD = 2;
const RESPONSE_TWO_VERIFICATION = 3;
const RESPONSE_STATUS_NOTIFY = 4;
const RESPONSE_CARD_INFO = 5;
const STATUS_TYPE_LEAVE = 4;
// Delivery status

const NOT_DELIVERY = 1;
const IN_DELIVERY = 2;
const DELIVERED = 3;
const DELEVERY_CANCELED = 4;
const STATIC_PAGE_PUBLIC = 1;

// Contact
const CONTACT_TYPE_EMAIL = 1;
const CONTACT_TYPE_PHONE = 2;
const OPTIONS_INQUIRY_TYPE = [
  '1' => '出展について',
  '2' => '資料請求',
  '3' => 'ガチャポについて',
  '4' => 'その他について',
];

// Coupon
const COUPON_TYPE_PERCENT = 1;
const COUPON_TYPE_PRICE = 2;

const FORGOT_PASSWORD = [
  'exists_email' => 0,
];

const FILE_ERROR_STATUS = 0;

// Review status
const NOT_APPROVED_REVIEW = 1; // not approve/保留中
const APPROVED_REVIEW = 2; //approved/承認
const DISAPPROVAL = 3; //disapproval/否認
const MAX_LASTEST_REVIEW = 3;
