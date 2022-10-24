<template>
  <el-table
    v-loading="loading"
    :data="data"
    style="width: 100%"
    :default-sort="defaultSort"
    @sort-change="sort"
  >
    <!-- ID - Start -->
    <el-table-column
      v-if="column && column.id"
      prop="log_id"
      label="ID"
      width="90"
      sortable
    />
    <!-- ID - End -->

    <!-- Name - Start -->
    <el-table-column
      v-if="column && column.name"
      prop="name"
      :label="$t('admin.activity.name')"
      width="240"
      sortable
    />
    <!-- Name - End -->

    <!-- Email - Start -->
    <el-table-column
      v-if="column && column.email"
      prop="email"
      :label="$t('admin.activity.email')"
      min-width="240"
      sortable
    />
    <!-- Email - End -->

    <!-- Activity - Start -->
    <el-table-column
      v-if="column && column.activity"
      prop="activity"
      :label="$t('admin.activity.activity')"
      min-width="240"
      sortable
    />
    <!-- Activity - End -->

    <!-- Detail - Start -->
    <el-table-column
      v-if="column && column.detail"
      prop="detail"
      :label="$t('admin.activity.detail')"
      min-width="240"
      sortable
    />
    <!-- Detail - End -->

    <!-- IP Address - Start -->
    <el-table-column
      v-if="column && column.ipaddress"
      prop="ip"
      :label="$t('admin.activity.ipaddress')"
      width="190"
      sortable
    />
    <!-- IP Address - End -->

    <!-- Access Time - Start -->
    <el-table-column
      v-if="column && column.accessTime"
      prop="access_time"
      :label="$t('admin.activity.accessTime')"
      width="200"
      sortable
      ><template #default="{ row }">
        <div v-if="row.access_time">
          {{ $moment(row.access_time).format('YYYY/MM/DD HH:hh:ss') }}
        </div>
      </template></el-table-column
    >
    <!-- Access Time - End -->
  </el-table>
</template>

<script>
  import { mapState } from 'vuex'
  import { camelCase } from 'lodash'
  export default {
    props: {
      data: { type: Array, default: () => [] },
      loading: { type: Boolean, default: false },
    },
    computed: {
      routeQuery() {
        return this.$route.query
      },
      defaultSort() {
        if (this.routeQuery.direction && this.routeQuery.order) {
          const direction =
            this.routeQuery.direction === 'asc' ? 'ascending' : 'descending'
          return {
            prop: this.routeQuery.order,
            order: direction,
          }
        }
        return { prop: 'id', order: 'descending' }
      },

      ...mapState('table', {
        column: (state) => state.logListColumn,
      }),
    },
    methods: {
      camelCase,

      sort(data) {
        let order = null
        let direction = null

        if (data.prop && data.order) {
          // Get table column prop name and direction (asc/desc)
          order = data.prop
          direction = data.order

          if (direction === 'ascending') {
            direction = 'asc'
          } else if (direction === 'descending') {
            direction = 'desc'
          }

          const query = {
            ...this.routeQuery,
            ...{ order, direction, page: 1 },
          }
          this.$router.push({ name: this.routeName, query })
        } else {
          const query = { ...this.routeQuery }

          // Delete property when there is no order by selected
          this.$delete(query, 'order')
          this.$delete(query, 'direction')

          this.$router.push({ name: this.routeName, query })
        }
      },
    },
  }
</script>
