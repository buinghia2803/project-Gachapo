import camelCase from 'lodash/camelCase'
import CONFIG from './config'
import routes from '~/configs/routes'

export default ({ $axios, $cookies, app }, inject) => {
  class Relipa {
    constructor() {
      $axios.onError(async error => {
        const statusCode = error.response.status ?? 0

        if (statusCode === 401 && refreshToken) {
          try {
            const { data } = await $axios.post('/refresh', { refresh_token: refreshToken })
            $cookies.set(CONFIG.REFRESH_TOKEN, data.refresh_token, { maxAge: CONFIG.REFRESH_TOKEN_MAX_AGE, path: '/' })
            if (app.$auth) {
              app.$auth.setUserToken(data.access_token)
            }
            const originalRequest = error.config
            originalRequest.headers.Authorization = 'Bearer ' + data.access_token

            return $axios(originalRequest)
          } catch (e) {
            $cookies.remove(CONFIG.REFRESH_TOKEN, { path: '/' })

            return Promise.reject(e)
          }
        }
        // Refresh token if expired
        const refreshToken = $cookies.get(CONFIG.REFRESH_TOKEN)

        return Promise.reject(error)
      })

      this.axios = $axios

      Object.entries(routes).forEach(([path, methods]) => {
        Object.entries(methods).forEach(([method, options]) => {
          this.buildMethod(method, path, options)
        })
      })
    }

    /**
     * Method builder
     *
     * @param {string} method
     * @param {string} path
     * @param {object} options
     *
     * @return {object}
     */
    buildMethod(method, path, options = {}) {
      const key = options.name || camelCase(`${method}-${path}`)
      let _path = this.buildPath(path, options)

      switch (method) {
        case 'get':
          this[key] = async (params, config = {}) => {
            config.params = params
            const {data} = await this.axios.get(_path, config)

            return data
          }
          break
        case 'post':
          this[key] = async (params, config = {}) => {
            if(options.consumes && this._isMultipart(options.consumes)) {
              const formData = new FormData();
              Object.entries(params).forEach(([key, value]) => {
                if (Array.isArray(value)) {
                  value.forEach(item => {
                    formData.append(key + '[]', item)
                  })
                } else {
                  formData.set(key, value)
                }
              })
              params = formData
            }
            const { data: { data } } = await this.axios.post(_path, params, config)

            return data
          }
          break
        case 'put':
          this[key] = (data, config = {}) => this.axios.put(_path, data, config)
          break
        case 'delete':
          this[key] = (config = {}) => this.axios.delete(_path, config)
          break
        case 'index':
          this[key] = (config = {}) => this.axios.get(_path, config)
          break
        case 'store':
          this[key] = (data, config = {}) => this.axios.post(_path, data, config)
          break
        case 'show':
          this[key] = async (params, config = {}) => {
            let path = ''
            for (const key in params) {
              if(_path.includes('{'+key+'}')) {
                path = _path.replace('{'+key+'}', params[key])
                delete params[key]
              }
            }
            config.params = params
            if(config && config.id) {
              delete config.id
            }
            const { data } = await this.axios.get(`${path}`, config)

            return data
          }
          break
        case 'update':
          this[key] = (data, config = {}) => this.axios.put(`${_path}/${data.id}`, data, config)
          break
        case 'destroy':
          this[key] = (data, config = {}) => this.axios.delete(`${_path}/${data.id}`, data, config)
          break
        case 'resource':
          ['index', 'store', 'show', 'update', 'destroy'].forEach(action => this.buildMethod(action, path, options))
          break
        default:
          break
      }
    }

    /**
     * Method build path with prefix
     *
     * @param {string} path
     *
     * @return {string}
     */
    buildPath(path, options) {
      const prefix = options.prefix || ''
      if (!prefix) {
        return path
      }
      
      return prefix + path
    }

    /**
     * Check is multipart form
     * @param {string} consume
     * @returns
     */
    _isMultipart(consume) {
      if (!consume) {
        return false
      }

      return consume === 'multipart/form-data'
    }

    /**
     * Check is octet stream
     * @param {string} consume
     * @returns
     */
    _isOctetStream(consume) {
      if (!consume) {
        return false
      }
      return  consume === 'application/octet-stream'
    }

    _isArrayBuffer(produces) {
      if (!produces) {
        return false
      }
      return produces.some(produce => {
        const targets = ['text/csv', 'application/pdf']
        return targets.includes(produce)
      })
    }
  }

  inject('relipa', new Relipa())
}
