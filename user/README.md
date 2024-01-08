# D1NuxtJSBase
## Getting started
## Constitution

Phát triển với `Nuxt.js + ES6 + Ant Design UI`.
Alt CSS sử dụng `SCSS`.

Ngoài ra, `relpa` được bao gồm dưới dạng một plugin như một thư viện để gọi API.

Có thể có một README ngay dưới thư mục, vì vậy hãy tham khảo thêm.

```
src
 ├── assets: icons / scss / images etc.
 ├── components: vue components
 ├── config: Logic group used in nuxt.config.js
 ├── constants: constant management
 ├── env: Settings for each environment
 ├── layouts: Page common layout
 ├── middleware: Common page processing
 ├── mixins: Vue mixin
 ├── pages: Pages
 ├── plugins: Plugins
 ├── spec: Test file storage
 ├── static: Static file
 ├── store: vuex store
 ├── (From here on the file)
 ├── .eslintrc.js: ESLint setting
 ├── jest.config.js: Jest (test tool) configuration file
 └── nuxt.config.js: Project definition
```
# Install dependencies
$ yarn

# Start-up
# Use the following three commands depending on the connection destination
$ yarn dev # => Connect to local local server api
$ yarn dev: local # => connect to local server api
$ yarn dev: swagger # => Connect to swagger in local environment

# lint
$ yarn lint
$ yarn lint: fix # auto fix error format eslint

# Build and launch
$ yarn build: local
$ yarn start

# Generate static file
$ yarn generate

# File size analysis
$ yarn analyze

## Documantations

## Routes
Trong file ``config/routes.js``:
 - Bao gồm các url api và function call api được định nghĩa.
 TH1: Khai báo và sử dụng resource
  Example:
  ```js
    user: {
      resource: {}
    },
  ```
    Khi khai báo resource thì api sẽ tương ứng đương với khai báo 5 action: ``'index', 'store', 'show', 'update', 'destroy'``
    Trong đó:
      - ``index``  : api lấy danh sách.
      - ``store``  : api tạo mới.
      - ``show``   : api lấy thông tin chi tiết.
      - ``update`` : api cập nhật thông tin.
      - ``destroy``: api xóa bản ghi.
 TH2: Khai báo theo các phương thức GET, POST, PUT, DELETE
  Example:
  ```js
    'menu': {
      get: {
        name: 'getMenus'
      },
      post: {
        name: 'createMenu'
      },
      put: {
        name: 'updateMenu'
      },
      delete: {
        name: 'deleteMenu'
      },
    }
  ```
## Stepup

  1. Khai báo components:
  ```bash
    <template>
      <app-component>
    </template>

    const AppComponent = () => import'~/components/atoms/AppComponent'

    <script>
      components: { AppComponent }
    </script>
  ```
  2. Cách sử dụng plugin API
    - Plugin API được inject thông qua property `$api`
    - Cấu hình của plugin API được lưu tại `configs/routes.js`
    - Tên phương thức sẽ được binding tự động bằng cách nối method và path của route theo format camelCase
    - Ví dụ trong cấu hình dưới đây, **permission** là path, còn **get** là method
    ```bash
    permission: {
      get: {}
    },
    ```
    - Cách sử dụng là gọi đến `this.$api.getPermission()`
    - Phương thức này trả về một [axios request](https://github.com/axios/axios), cho nên các tham số truyền vào bên trong hàm cũng tương tự như các tham số truyền vào một `axios request`
    - Nếu muốn custom tên phương thức, hãy chỉ định tham số **name**, ví dụ:
    ```bash
    'menu/move': {
      post: {
        name: 'moveMenu'
      }
    }
    ```
    - Chỉ định method cho route là **resource** đồng nghĩa với việc tạo tự động 5 route tương ứng cho một API Resource, bao gồm **index**, **store**, **show**, **update**, **destroy**

    | Method | URI        | Route   | Function                   |
    | ------ | ---------- | ------- | -------------------------- |
    | GET    | /user      | index   | this.$relipa.indexUser()   |
    | POST   | /user      | store   | this.$relipa.storeUser()   |
    | GET    | /user/{id} | show    | this.$relipa.showUser()    |
    | PUT    | /user/{id} | update  | this.$relipa.updateUser()  |
    | DELETE | /user/{id} | destroy | this.$relipa.destroyUser() |
  **Example:**
    ```js
      this.$relipa['method name'](data)
      await this.$relipa['method name'](data)
      this.$relipa['method name'](data).then(res => {
        // do something
      }).catch(err => {
        // do something when has error
      })
    ```

    ```js
      // configs/routes.js
      permission: {
        get: {
          name: 'getPermission'
        }
      },
      // components/organisms/roles/RoleForm.vue
      this.$relipa.getPermission().then(res => {
        const { data: { result: { data } } } = res
        this.permissions = data
      }).catch(err => {
        console.error(error)
      })
      // Some other usage
      this.$relipa.updateRole({ params: {id: 1, name: 'admin', guard_name: 'api'} })
  ```
  3. Cách khai báo và sử dụng module:

    - Mỗi module sẽ có cấu trúc:

      | Page  | Store | Component     | Mixins                  |
      | ----- | ----- | ------------- | ----------------------- |
      | users | user  | UserComponent | relipa-query-builder.js |

    - Trong đó:
      - Page là router path: /users
      - Store chứa các thông tin call API và get, set data liên quan đến đối tượng user
      - UserComponent là các component thành phần của user
      - Mixins chứa các phương thức fetch() và các phương thức xử lý phân trang, sort lên url thành các query params
      - Đối với các page không sử dụng mixins/relipa-query-builder.js sẽ viết riêng phương thức fetch() ngang cấp đối tượng methods.
      **Chú ý:** Phương thức fetch phải viết dưới dạng async await để tránh việc không quản lý đc bất đồng bộ dữ liệu.
        `Tham khảo: https://nuxtjs.org/blog/understanding-how-fetch-works-in-nuxt-2-12`

  4. Đa ngôn ngữ:

    - Khai báo multilanguage trong configs/locales/
    - Locale mặc định là en

