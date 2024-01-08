export default {
  'auth/me': {
    post: {
      name: 'updateProfile'
    },

    get: {
      name: 'getProfile'
    }
  },

  'update-profile': {
    post: {
      name: 'updateProfileSetting'
    }
  },

  'upload': {
    post: {
      name: 'uploadFile',
    }
  },

  user: {
    resource: {}
  },

  permission: {
    get: {
      name: 'getPermission'
    }
  },

  'generate-link': {
    get: {
      name: 'generateLinkPW'
    }
  },

  // Register for user
  '/user': {
    post: {
      name: 'registerUser',
    }
  },

  '/login': {
    post: {
        name: 'userLogin'
      }
    },

  // Company
  'company': {
    post: {
      name: 'registerCompany',
      consumes: 'multipart/form-data'
    }
  },

  // contact
  'contact': {
    post: {
      name: 'registerContact',
    }
  },

  // forgot-password
  'generate-link': {
    get: {
      name: 'forgotPasssword',
    }
  },

  // check secret key
  'check-secret-key': {
    post: {
      name: 'checkSecretKey',
    }
  },

  // reset password
  'password-reset': {
    post: {
      name: 'resetPassword',
    }
  },

  'category': {
    get: {
      name: 'getListOfSearchTerms'
    }
  },

  'page': {
    show: {
      name: 'getPageWithType'
    },
    get: {
      name: 'getPageList'
    }
  },

  // review gacha
  'gacha/{id}/reviews': {
    show: {
      name: 'getReview'
    }
  },

  // home
  'home': {
    get: {
      name: 'getInfoHomePage'
    }
  },

  // notification
  'user/notification': {
    get: {
      name: 'getNotification'
    }
  },

  // gacha
  'gacha': {
    resource: {}
  },

  'user/verification': {
    get: {
      name: 'verifyAccount'
    }
  },

  //browsing history gacha
  'user/browsing-history-gacha': {
    get: {
      name: 'getBrowsingHistoryGacha'
    }
  },

  // order
  'order': {
    resource: {}
  },

  'user/2nd-factor': {
    get: {
      name: 'verify2ndFactor'
    }
  },

  'login': {
    post: {
      name: 'userLogin'
    }
  },

  // list favorite gacha
  'gacha/favorite/list': {
    get: {
      name: 'getListFavorite'
    }
  },

  // detail notification by id
  'user/notification/{id}': {
    show: {
      name: 'getDetailNotification'
    }
  },

  // logout
  'logout': {
    post: {
      name: 'logoutUser'
    }
  },

  // detail order
  'order/{id}': {
    show: {
      name: 'getDetailOrder'
    }
  },

  // review order
  'order/review': {
    post: {
      name: 'reviewOrder'
    }
  },

  'review-by-user-id': {
    get: {
      name: 'getReviewByUserId'
    }
  }
}
