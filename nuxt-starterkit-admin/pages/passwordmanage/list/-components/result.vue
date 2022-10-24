<template>
  <el-table
    v-loading="loading"
    :data="data"
    style="width: 100%"
    :default-sort="defaultSort"
    @sort-change="sort"
  >
    <!-- website - Start -->
    <el-table-column
      v-if="column && column.website"
      prop="website"
      :label="$t('password.list.website')"
      min-width="200"
      sortable
    >
      <template #default="{ row }">
        {{ row.website }}
      </template>
    </el-table-column>
    <!-- website - End -->
    <!-- username - Start -->
    <el-table-column
      v-if="column && column.username"
      prop="username"
      :label="$t('password.list.username')"
      min-width="200"
      sortable
    >
      <template #default="{ row }">
        {{ row.username }}
      </template>
    </el-table-column>
    <!-- username - End -->
    <!-- password - Start -->
    <el-table-column
      v-if="column && column.password"
      prop="password"
      :label="$t('password.list.password')"
      min-width="200"
      sortable
    >
      <template #default="{ row }">
        {{ row.password }}
      </template>
    </el-table-column>
    <!-- password - End -->
    <!-- site_name - Start -->
    <el-table-column
      v-if="column && column.siteName"
      prop="site_name"
      :label="$t('password.list.site_name')"
      min-width="200"
      sortable
    >
      <template #default="{ row }">
        {{ row.site_name }}
      </template>
    </el-table-column>
    <!-- site_name - End -->
    <!-- email - Start -->
    <el-table-column
      v-if="column && column.email"
      prop="email"
      :label="$t('password.list.email')"
      min-width="200"
      sortable
    >
      <template #default="{ row }">
        {{ row.email }}
      </template>
    </el-table-column>
    <!-- email - End -->
  
    <!-- Timestamps - Start -->
    <el-table-column
      v-if="column && column.registrationDate"
      :label="$t('admin.list.registrationDate')"
      width="120"
      prop="created"
      sortable
    >
      <template #default="{ row }">
        <div v-if="row.created_at">
          {{ $moment(row.created_at).format('YYYY/MM/DD') }}
        </div>
      </template>
    </el-table-column>
    <!-- Timestamps - End -->

    <!-- Toolbar - Start -->
    <el-table-column :fixed="toolbarFixed" width="150">
      <template #default="{ row }">
        <div class="row mx-n1 w:justify-center">
          <div class="px-1 col-auto">
            <NuxtLink :to="`/passwordmanage/${row.id}/edit`">
              <TableButton preset="edit" label="編集" />
            </NuxtLink>
          </div>
          <div class="px-1 col-auto">
            <TableButton
              preset="delete"
              label="削除"
              @click="confirmDelete(row)"
            />
          </div>
        </div>
      </template>
    </el-table-column>
    <!-- Toolbar - End -->
  </el-table>
</template>

<script>
  import { mapState } from 'vuex'
  import { camelCase } from 'lodash'
  import { TableButton } from '@/components/table'
  import { SuccessMsg, ErrorMsg } from '@/presets/notification/pages/form'

  export default {
    components: { TableButton },

    props: {
      data: {type: Array, default: () => []},
      loading: { type: Boolean, default: false },
    },

    data() {
      return {
        load: this.loading,
        resetData: this.$props.data,
      }
    },

    computed: {
      toolbarFixed() {
        let fixed = false
        if (this.$screen.md) fixed = 'right'
        return fixed
      },
      routeQuery() {
        return this.$route.query
      },
      defaultSort() {
        if (this.routeQuery.direction && this.routeQuery.order) {
          const direction = this.routeQuery.direction === 'asc' ? 'ascending' : 'descending'
          return {
            prop: this.routeQuery.order,
            order: direction,
          }
        }
        return { prop: 'id', order: 'descending'}
      },


      ...mapState('table', {
        column: (state) => state.passwordManageListColumn,
      }),
    },

    mounted() {
      console.log(this.column);
    },

    methods: {
      camelCase,
      // async resetData() {
      //   const result = await this.$axios.get('/admin/user/list/filter', { params })
      //   console.log(result);
      // },

      async deleteData(row) {
        this.load = true
        const result = await this.$axios.post('/password/manage/destroy', row)
        const isSuccess = result.status === 200
        if (isSuccess) {
          this.$nuxt.refresh()
          this.$notify(SuccessMsg(this))
          

        } else {
          this.$notify.error(ErrorMsg(this))
        }
        this.load = false
      },

      confirmDelete(row) {
        this.$confirm('Are you sure to delete this data?')
          .then(() => {
            this.deleteData(row);
          }).catch(() => {})
      },

      sort(data) {
        let order = null
        let direction = null

        if (data.prop && data.order) {
          order = data.prop
          direction = data.order

          if (direction === 'ascending') {
            direction = 'asc'
          } else if (direction === 'descending') {
            direction = 'desc'
          }

          const query = {
            ...this.routeQuery,
            ...{ order, direction, page: 1},
          }
          this.$router.push({name: this.routeName, query})
        } else {
          const query = { ...this.routeQuery }

          this.$delete(query, 'order')
          this.$delete(query, 'direction')

          this.$router.push({name: this.routeName, query})

        }
      },
    },
  }
</script>