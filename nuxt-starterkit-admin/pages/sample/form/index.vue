<template>
  <Page title="ユーザー登録" :breadcrumbs="breadcrumbs" :container="1200">
    <FormContainer :title="$t('sample.page.title')" :is-loading="isLoading">
      <el-form
        ref="adminForm"
        :model="form"
        :rules="rules"
        hide-required-asterisk
        status-icon
        label-width="180px"
        label-position="left"
        @submit.native.prevent="submit('adminForm')"
      >
        <FormContainerRow :title="$t('sample.page.basicinfo')">
          <FormContainerTwoColumn>
            <template #column-1>
              <FormItem :name="$t('sample.input.name')" prop="name" required>
                <template #input>
                  <el-input v-model="form.name"></el-input>
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.birthday')" prop="birthday">
                <template #input>
                  <el-date-picker
                    v-model="form.birthday"
                    type="date"
                    placeholder="Pick a date"
                    style="width: 100%"
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                  ></el-date-picker>
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.gender')" prop="gender">
                <template #input>
                  <el-radio v-model="form.gender" label="1">男性</el-radio>
                  <el-radio v-model="form.gender" el-radio label="2"
                    >女性</el-radio
                  >
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.email')" prop="email" required>
                <template #input>
                  <el-input v-model="form.email"></el-input>
                </template>
              </FormItem>
              <FormItem
                :name="$t('sample.input.password')"
                prop="password"
                :required="passwordRequired"
              >
                <template #input>
                  <el-col v-if="showPasswordInput">
                    <el-input
                      v-model="form.password"
                      type="password"
                      autocomplete="off"
                      show-password
                    ></el-input>
                  </el-col>
                  <el-button
                    v-else
                    type="primary"
                    @click="showPasswordInput = true"
                    >{{ $t('sample.page.changepass') }}</el-button
                  >
                </template>
              </FormItem>
            </template>
            <template #column-2>
              <FormItem
                :name="$t('sample.input.postcode')"
                prop="postcode"
                required
              >
                <template #input>
                  <el-col :span="11">
                    <el-input v-model="form.postcode"></el-input>
                  </el-col>

                  <el-col :span="6">
                    <div class="w:ml-4">
                      <el-button
                        type="primary"
                        class="search-button primary-plain-button"
                        plain
                        size="small"
                        @click="onSearch()"
                        >検索</el-button
                      >
                    </div>
                  </el-col>
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.select')" prop="prefectureId">
                <template #input>
                  <el-col :span="11">
                    <el-select
                      v-model="form.prefectureId"
                      filterable
                      remote
                      placeholder="都道府県を選択"
                      :remote-method="remoteMethod"
                      :loading="loadingOption"
                    >
                      <el-option
                        v-for="item in options"
                        :key="item.id"
                        :label="item.prefecture"
                        :value="item.id"
                      >
                      </el-option>
                    </el-select>
                  </el-col>
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.address')" prop="address">
                <template #input>
                  <el-input v-model="form.address" type="textarea"></el-input>
                </template>
              </FormItem>
              <FormItem name="番地" prop="password">
                <template #input>
                  <el-input type="text" autocomplete="off"></el-input>
                </template>
              </FormItem>
              <FormItem name="建物名・部屋番号" prop="password">
                <template #input>
                  <el-input type="text" autocomplete="off"></el-input>
                </template>
              </FormItem>
            </template>
          </FormContainerTwoColumn>
        </FormContainerRow>

        <FormContainerRow :title="$t('sample.page.basicinfo')" class="mt-4">
          <FormContainerTwoColumn>
            <template #column-1>
              <FormItem :name="$t('sample.input.activehour')" prop="activehour">
                <template #input>
                  <el-time-picker
                    v-model="form.activehour"
                    placeholder="時間を選択"
                    style="width: 100%"
                    value-format="HH:mm:ss"
                  ></el-time-picker>
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.hobby')" prop="hobby">
                <template #input>
                  <el-checkbox-group v-model="form.hobby">
                    <el-checkbox
                      label="バドミントン"
                      name="hobby"
                    ></el-checkbox>
                    <el-checkbox
                      label="バスケットボール"
                      name="hobby"
                    ></el-checkbox>
                    <el-checkbox label="ゲーム" name="hobby"></el-checkbox>
                    <el-checkbox
                      label="disabled"
                      name="hobby"
                      disabled
                    ></el-checkbox>
                    <el-checkbox
                      label="selected and disabled"
                      name="hobby"
                      disabled
                    ></el-checkbox>
                  </el-checkbox-group>
                </template>
              </FormItem>
              <FormItem :name="$t('sample.input.price')" prop="price">
                <template #input>
                  <el-input v-model="form.price"></el-input>
                </template>
              </FormItem>
              <FormItem name="好きな食べ物" prop="checkbox_dynamic">
                <template #input>
                  <ModalDynamicCheckbox
                    :resources="checkBoxList"
                    :value="checkBoxSelected"
                    @confirm="onConfirm"
                  />
                  <div class="col-12">
                    <el-tag
                      v-for="tag in checkBoxSelectedData"
                      :key="tag.id"
                      size="mini"
                      closable
                      class="w:mr-1"
                      @close="removeCheckBoxSelected(tag)"
                    >
                      {{ tag.label }}
                    </el-tag>
                  </div>
                </template>
              </FormItem>
            </template>
            <template #column-2>
              <!-- Single Image Input -->
              <FormItem :name="$t('sample.input.image')" prop="image">
                <template #input>
                  <single-image-input
                    v-model="fileSingle"
                    tooltip="*jpg/png files with a size less than 500kb"
                  ></single-image-input>
                </template>
              </FormItem>

              <!-- Multiple Image Input -->
              <FormItem :name="$t('sample.input.image')" prop="image">
                <template #input>
                  <multiple-image-input
                    v-model="fileMultiple"
                    :limit="5"
                    tooltip="*jpg/png files with a size less than 500kb, max 5 image"
                  ></multiple-image-input>
                </template>
              </FormItem>
            </template>
          </FormContainerTwoColumn>
        </FormContainerRow>

        <!-- Button Save and Reset -->
        <div class="w:items-center">
          <div class="row">
            <div class="w:items-center w:flex w:items-center w:justify-center">
              <el-button
                type="primary"
                class="submit-button"
                @click="onSubmit('adminForm')"
                >{{ $t('sample.page.submit') }}</el-button
              >
            </div>
          </div>
        </div>
      </el-form>
    </FormContainer>
  </Page>
</template>

<script>
  import ModalDynamicCheckbox from '../modal/dyanamic-checkbox'
  import Page from '@/layouts/admin'
  import FormContainer from '@/components/form/container'
  import FormContainerRow from '@/components/form/container/container-row'
  import FormContainerTwoColumn from '@/components/form/container/container-2-columns'
  import FormItem from '@/components/form/item'
  import { SuccessMsg, ErrorMsg } from '@/presets/notification/pages/form'
  import SingleImageInput, {
    singleImageInitial,
  } from '@/components/_form/SingleImageInput.vue'
  import MultipleImageInput, {
    multipleImageInitial,
  } from '@/components/_form/MultipleImageInput.vue'

  export default {
    auth: false,
    components: {
      Page,
      FormContainer,
      FormItem,
      SingleImageInput,
      MultipleImageInput,
      FormContainerRow,
      FormContainerTwoColumn,
      ModalDynamicCheckbox,
    },

    async asyncData({ $axios, params }) {
      if (params.id === undefined) {
        const defaultData = await $axios.$get('/admin/sample/form')
        defaultData.pageType = 'create'

        // Return as props
        return {
          defaultData,
        }
      } else {
        const defaultData = await $axios.$get(
          process.env.NUXT_SERVER_API + `/admin/sample/form/${params.id}`
        )

        defaultData.pageType = 'edit'

        // Return as props
        return {
          defaultData,
        }
      }
    },

    data: () => ({
      breadcrumbs: [
        { to: '/dashboard', label: 'ダッシュボード' },
        { to: '/sample/form2', label: 'ユーザ登録' },
      ],

      defaultData: false,
      isLoading: false,
      showPasswordInput: true,
      passwordRequired: true,
      isCreate: true,
      fileSingle: singleImageInitial(),
      fileMultiple: multipleImageInitial(),
      submitUrl: 'admin/sample/form',
      searchUrl: 'admin/sample/form/postcode?q=',
      form: {
        name: '',
        birthday: '',
        hobby: ['selected and disabled', 'Option A'],
        gender: null,
        postcode: '',
        prefectureId: '',
        address: '',
        activehour: '',
        price: '',
        email: null,
        password: null,
      },
      options: [],
      loadingOption: false,
      states: [],
      rules: {},
      dialogVisible: false,
      checkBoxSelected: [],
      checkBoxSelectedData: [],
      checkBoxList: {
        data: [
          { id: 1, label: 'ステーキ' },
          { id: 2, label: 'チキン' },
          { id: 3, label: 'ピザ' },
          { id: 4, label: 'ワッフル' },
          { id: 5, label: '牛肉' },
          { id: 6, label: 'モツァレラチーズ' },
          { id: 7, label: 'ベーコン' },
          { id: 8, label: 'コーンビーフ' },
        ],
      },
    }),

    async created() {
      this.isLoading = true
      try {
        if (this.defaultData.pageType === 'edit') {
          this.form.name = await this.defaultData.data.name
          this.submitUrl = '/sample/form/' + this.defaultData.data.id
        } else {
          this.states = await this.defaultData.data.postcode
        }
      } catch (e) {
        // console.log(e)
      }
      this.isLoading = false
    },

    mounted() {},

    methods: {
      onSubmit() {
        this.save()
      },

      resetForm(form) {
        this.$refs[form].resetFields()
        this.showPasswordInput = false
      },

      remoteMethod(query) {
        if (query !== '') {
          this.loadingOption = true
          setTimeout(() => {
            this.loadingOption = false
            this.options = this.states.filter((item) => {
              return item.prefecture.toLowerCase().includes(query.toLowerCase())
            })
          }, 200)
        } else {
          this.options = []
        }
      },

      async onSearch() {
        this.isLoading = true
        try {
          const Data = this.form.postcode

          await this.$axios
            .$get(this.searchUrl + Data)
            .then((res) => {
              this.options = [
                {
                  id: res.data[0].id,
                  prefecture: res.data[0].prefecture,
                },
              ]
              this.form.prefectureId = res.data[0].id
              console.log(this.form.prefectureId)
            })
            .catch((err) => {
              console.log(err)
            })
        } catch (e) {
          console.log(e)
        }
        this.isLoading = false
      },

      async save() {
        this.isLoading = true
        try {
          const options = {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          }

          // create empty form data named payload to sent to request
          const payload = new FormData()
          // append all form data except image
          for (const key of Object.keys(this.form)) {
            payload.append(key, this.form[key])
          }

          // append image
          if (this.fileSingle.file) {
            payload.append('file', this.fileSingle.file.raw)
          }

          // append multiple image
          if (this.fileMultiple.file) {
            this.fileMultiple.file.forEach((element, index) => {
              payload.append(`multipleImages[${index}]`, element.raw)
            })
          }

          const response = await this.$axios
            .$post(this.submitUrl, payload, options)
            .catch((err) => {
              console.log(err)
            })

          const isSuccess = response.status === 200
          // On success
          if (isSuccess) {
            // Move to admin list page
            // this.$router.push('/admins')
            // Display a notification
            this.$notify(SuccessMsg(this))
          } else {
            this.$notify.error(ErrorMsg(this))
          }
        } catch (err) {
          console.log(err)
        }
        this.$refs.adminForm.resetFields()
        this.isLoading = false
      },
      onConfirm(value) {
        this.checkBoxSelected = value
        this.checkBoxSelectedData = []
        value.forEach((value) => {
          const label = this.checkBoxList.data.find(
            (check) => check.id === value
          ).label
          this.checkBoxSelectedData.push({
            id: value,
            label,
          })
          return false
        })
      },
      confirmCheckBox(value) {
        this.checkBoxSelected = value
      },
      removeCheckBoxSelected(value) {
        this.checkBoxSelected.splice(this.checkBoxSelected.indexOf(value.id), 1)
        this.checkBoxSelectedData.splice(
          this.checkBoxSelectedData.indexOf(value),
          1
        )
      },
    },
  }
</script>
