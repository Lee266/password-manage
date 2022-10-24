<template>
  <el-table
    v-loading="loading"
    :data="data"
    style="width: 100%"
    :default-sort="defaultSort"
    @sort-change="sort"
  >
    <!-- Name - Start -->
    <el-table-column
      v-if="column && column.name"
      prop="name"
      :label="$t('admin.list.name')"
      min-width="200"
      sortable
    >
      <template #default="{ row }">
        {{ row.name }}
      </template>
    </el-table-column>
    <!-- Name - End -->

    <!-- Role - Start -->
    <el-table-column
      v-if="column && column.role"
      prop="role"
      :label="$t('admin.list.authority')"
      width="150"
      sortable
    >
      <template #default="{ row }">
        <div v-if="row.role">
          {{ $t(`auth.role.${camelCase(row.role.name)}`) }}
        </div>
      </template>
    </el-table-column>
    <!-- Role - End -->

    <!-- Email - Start -->
    <el-table-column
      v-if="column && column.email"
      prop="email"
      :label="$t('admin.list.email')"
      min-width="260"
      sortable
    />
    <!-- Email - End -->

    <!-- Company - Start -->
    <el-table-column
      v-if="column && column.company"
      prop="company"
      :label="$t('admin.list.companyName')"
      min-width="230"
      sortable
    >
      <template #default="{ row }">
        <div v-if="!row.company">-</div>
        <template v-else>
          <div class="w:py-1">
            {{ row.company.name }}
          </div>
        </template>
      </template>
    </el-table-column>
    <!-- Company - End -->

    <!-- Telp Number - Start -->
    <el-table-column
      v-if="column && column.telpNumber"
      prop="telp"
      :label="$t('admin.list.telpNumber')"
      min-width="230"
      sortable
    >
      <template #default="{ row }">
        <div v-if="!row.company">-</div>
        <template v-else>
          <div class="w:py-1">
            {{ row.company.phone }}
          </div>
        </template>
      </template>
    </el-table-column>
    <!-- Telp Number - End -->

    <!-- Residence - Start -->
    <el-table-column
      v-if="column && column.residence"
      prop="residence"
      :label="$t('admin.list.residence')"
      min-width="230"
      sortable
    >
      <template #default="{ row }">
        <div v-if="!row.company">-</div>
        <template v-else>
          <div class="w:py-1">
            {{ row.company.address }}
          </div>
        </template>
      </template>
    </el-table-column>
    <!-- Residence - End -->

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
            <NuxtLink :to="`/admin/${row.id}/edit`">
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
        column: (state) => state.adminListColumn,
      }),
    },

    mounted() {
      console.log(this.column)
    },

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
