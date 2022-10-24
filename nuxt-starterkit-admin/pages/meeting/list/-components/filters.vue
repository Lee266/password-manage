<template>
  <div>
    <!--error handler-->
    <div v-if="error.length >= 1" class="row" style="margin-bottom: 20px">
      <div class="col-md-12">
        <el-alert type="error">
          <span v-for="item in error" :key="item" class="error-message">
            {{ item }} <br />
          </span>
        </el-alert>
      </div>
    </div>

    <!--Form upload csv-->
    <el-form
      ref="form"
      label-width="120px"
      label-position="left"
      @submit.native.prevent
      @keydown.enter.prevent
    >
      <div class="row">
        <!--input upload csv-->
        <div class="col-md-6">
          <el-upload
            ref="uploadCSV"
            class="upload-demo"
            action="#"
            :multiple="false"
            :file-list="fileList"
            :auto-upload="false"
            prop="file"
            accept=".csv"
            :on-change="handleChange"
          >
            <el-button type="primary">{{ $t('meeting.select_btn') }}</el-button>
          </el-upload>
        </div>

        <div class="col-md-6"></div>

        <!--upload button-->
        <div class="col-md-6">
          <el-button
            size="mini"
            class="table-button"
            style="margin-top: 20px"
            plain
            icon="el-icon-plus"
            @click="uploadCSV"
          >
            <span class="w:text-sm lg:w:inline-block">{{
              $t('meeting.upload_btn')
            }}</span>
          </el-button>
        </div>
        <div class="col-md-6">
          <el-button
            size="mini"
            class="table-button"
            style="margin-top: 20px; float: right"
            type="success"
            icon="el-icon-download"
            @click="downloadCSV"
          >
            <span class="w:text-sm lg:w:inline-block">{{
              $t('meeting.download_btn')
            }}</span>
          </el-button>
        </div>
      </div>
      <div class="row w:mt-4">
        <div class="w:flex w:justify-end">
          <el-button
            size="mini"
            type="success"
            icon="el-icon-download"
            @click="exportCSV"
          >
            <span class="w:text-sm lg:w:inline-block">{{
              $t('meeting.csvExport')
            }}</span>
          </el-button>
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>
  import { camelCase } from 'lodash'
  import { ErrorMsg } from '@/presets/notification/pages/form'

  export default {
    props: {
      resources: { type: Object, default: () => {} },
    },

    data() {
      return {
        fileList: [],
        error: [],
        submitUrl: '/meeting/uploadCSV', // upload csv Api link
        downloadUrl: '/meeting/csvDownload', // download csv Api link
        exportCsvUrl: '/meeting/exportCsv', // export csv api link
        csvName: this.$t('meeting.csvTemplate'), // download csv name
      }
    },

    computed: {},

    methods: {
      camelCase,

      // handle file csv upload change to get the data
      handleChange(file, fileMultiple) {
        this.fileList = fileMultiple.slice(-1)
      },

      // refresh nuxt async data to refresh the table data
      async refresh() {
        await this.$nuxt.refresh()
      },

      async uploadCSV() {
        try {
          this.error = []

          const options = {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          }

          // create empty form data named payload to sent to request
          const payload = new FormData()

          // append csv file
          if (this.fileList) {
            this.fileList.forEach((element, index) => {
              if (element.raw) {
                payload.append(`csv`, element.raw)
              }
            })
          }

          // sent request via axios
          const response = await this.$axios.
            $post('/admin/'.this.submitUrl, payload, options)
            .catch((error) => {
              // if there is validatioon error then sent to error data
              if (error.response) {
                const data = error.response.data
                this.error.message = null

                if (data.message.length > 0) {
                  data.message.forEach((value, index) => {
                    if (value.error) {
                      Object.keys(value.error).forEach((key) => {
                        if (value.error[key]) {
                          const message = JSON.stringify(value.error[key])
                          const errorMessage = message
                            .replace('["', '')
                            .replace('"]', '')

                          if (value.line != null)
                            this.error.push(
                              value.line + '行目の ' + errorMessage
                            )
                          else this.error.push(errorMessage)
                        }
                      })
                    }
                  })
                }
              }
            })

          const isSuccess = response.status === 200
          // On success
          if (isSuccess) {
            // Display a notification
            // Move to B5 page
            this.refresh()
          } else {
            this.$notify.error(ErrorMsg(this))
          }
        } catch (err) {
          // On exception, display an invalid login message
          this.$notify.error(ErrorMsg(this))
        }
      },

      async downloadCSV() {
        try {
          this.error = []

          // sent request via axios
          await this.$axios
            .$get('/admin/'.this.downloadUrl, { responseType: 'blob' })
            .then((response) => {
              // download blob CSV file
              const blob = new Blob([response], {
                type: 'text/csv',
                // type: 'application/vnd.ms-excel',
                // type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
              })
              console.log(blob)
              const fileURL = window.URL.createObjectURL(blob)
              const fileLink = document.createElement('a')
              fileLink.href = fileURL
              // fileLink.setAttribute('charset', 'SJIS-win')
              fileLink.setAttribute('download', this.csvName + '.csv')
              document.body.appendChild(fileLink)
              fileLink.click()
              window.URL.revokeObjectURL(fileURL)
              document.body.removeChild(fileLink)
            })
        } catch (err) {
          console.log(err)
          // On exception, display an invalid login message
          this.$notify.error(ErrorMsg(this))
        }
      },

      async exportCSV() {
        try {
          await this.$axios
            .$get('/admin/'.this.exportCsvUrl, { responseType: 'blob' })
            .then((response) => {
              const blob = new Blob([response], {
                type: 'text/csv',
              })
              const fileURL = window.URL.createObjectURL(blob)
              const fileLink = document.createElement('a')
              fileLink.href = fileURL
              fileLink.setAttribute('charset', 'SJIS-win')
              fileLink.setAttribute('download', this.csvName + '.csv')
              document.body.appendChild(fileLink)
              fileLink.click()
              window.URL.revokeObjectURL(fileURL)
              document.body.removeChild(fileLink)
            })
        } catch (err) {
          console.log(err)
          // On exception, display an invalid login message
          this.$notify.error(ErrorMsg(this))
        }
      },
    },
  }
</script>
<style scoped>
  .error-message {
    color: red;
    font-weight: bold;
    padding-left: 0;
  }
</style>
