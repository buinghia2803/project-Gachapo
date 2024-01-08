/* eslint-disable no-useless-escape */
export default (context, inject) => {
  const util = {
    /**
     * Get form data
     *
     * @param {Object} data
     * @param {Array} requiredFields
     * @param {Array} optionalFields
     * @return {Object} form data
     */
    getFormData: (data, requiredFields = [], optionalFields = []) => {
      const form = {}
      requiredFields.forEach(key => {
        if (data[key] !== undefined && data[key] !== null && data[key] !== '') {
          form[key] = data[key]
        }
      })
      optionalFields.forEach(key => {
        form[key] = data[key]
      })
      return form
    },

    /**
     * Download file
     *
     * @param {Object} data
     * @param {String} type
     * @param {String} name
     */
    downloadFile: ({ data, type, name }) => {
      if (!process.client) {
        return
      }
      const blob = new Blob([data], { type })
      const element = window.document.createElement('a')
      element.href = window.URL.createObjectURL(blob)
      element.download = name
      document.body.appendChild(element)
      element.click()
      document.body.removeChild(element)
      window.URL.revokeObjectURL(blob)
    },

    /**
     * Check user agent
     * @returns {Boolean}
     */
    checkAgentMobile () {
      const agent = navigator.userAgent || navigator.vendor || window.opera

      const agentCheckMobile = (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|iPad|playbook|silk|iPhone|iPod/i.test(agent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(agent.substr(0, 4)))

      return agentCheckMobile
    },

    /**
     * Ramdom generate string
     * @param {Number} length
     * @returns {String}
     */
    generateString (length) {
      let result = ''
      const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'

      const characterLength = characters.length

      for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * characterLength))
      }

      return result
    },

    /**
     * Resize image
     *
     * @param {object} setting
     * @return {blob} file data
     */
    resizeImage ({ file, maxSize }) {
      const reader = new FileReader()
      const image = new Image()
      const canvas = document.createElement('canvas')
      const dataURItoBlob = dataURI => {
        const bytes = dataURI.split(',')[0].includes('base64')
          ? atob(dataURI.split(',')[1])
          : unescape(dataURI.split(',')[1])
        const mime = dataURI.split(',')[0].split(':')[1].split(';')[0]
        const max = bytes.length
        const ia = new Uint8Array(max)
        for (let i = 0; i < max; i++) { ia[i] = bytes.charCodeAt(i) }
        return new Blob([ia], { type: mime })
      }
      return new Promise((resolve, reject) => {
        if (!file.type.match(/image.*/)) {
          reject(new Error('Not an image'))
          return
        }
        reader.onload = readerEvent => {
          image.onload = () => {
            let width = image.width
            let height = image.height
            if (width > height) {
              if (width > maxSize) {
                height *= maxSize / width
                width = maxSize
              }
            } else if (height > maxSize) {
              width *= maxSize / height
              height = maxSize
            }
            canvas.width = width
            canvas.height = height
            canvas.getContext('2d').drawImage(image, 0, 0, width, height)
            const dataUrl = canvas.toDataURL('image/jpeg')
            return resolve(dataURItoBlob(dataUrl))
          }
          image.src = readerEvent.target.result
        }
        reader.readAsDataURL(file)
      })
    },

    /**
     * Add leading character for number
     *
     * @param {Number} num - number input
     * @param {Number} places - pad replace
     * @param {String} character - Character with replaced
     * @return {String} number with pad
     */
    numberPad (num, places, character = '0') {
      if (!Number.isInteger(num) || !Number.isInteger(places)) {
        return
      }

      return String(num).padStart(places, character)
    }

  }

  inject('util', util)
}
