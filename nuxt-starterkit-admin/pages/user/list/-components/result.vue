<template>
  <el-table
    v-loading="loading"
    :data="data"
    style="width: 100%"
    :default-sort="defaultSort"
    class="w:d-none"
    @sort-change="sort"
  >
    <!-- Name - Start -->
    <el-table-column
      v-if="column && column.username"
      :label="$t('admin.input.username')"
      min-width="235"
      prop="name"
      sortable
    >
      <template #default="{ row }">
        {{ row.name }}
      </template>
    </el-table-column>
    <!-- Name - End -->

    <!-- Email - Start -->
    <el-table-column
      v-if="column && column.email"
      :label="$t('admin.input.email')"
      prop="email"
      min-width="250"
      sortable
    />
    <!-- Email - End -->

    <!-- Timestamps - Start -->
    <el-table-column
      v-if="column && column.createdAt"
      :label="$t('admin.input.createdAt')"
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
    <el-table-column width="150">
      <template #default="{ row }">
        <div class="row mx-n1 w:justify-center">
          <div class="px-1 col-auto">
            <NuxtLink :to="`/user/${row.id}/edit`">
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
  export default {
    components: { TableButton },

    props: {
      data: { type: Array, default: () => [] },
      loading: { type: Boolean, default: false },
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
        column: (state) => state.userListColumn,
      }),
    },

    // mounted() {
    //   console.log(this.column)
    // },

    methods: {
      camelCase,

      confirmDelete(row) {
        this.$confirm('Are you sure to delete this data?')
          .then(() => {
            console.log('Delete', row)
          })
          .catch(() => {})
      },

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
