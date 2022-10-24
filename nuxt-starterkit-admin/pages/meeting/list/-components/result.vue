<template>
  <el-table
    v-loading="loading"
    :data="data"
    :default-sort="{ prop: 'title', order: 'ascending' }"
    style="width: 100%"
    resizable
    border
  >
    <el-table-column
      prop="title"
      :label="$t('meeting.column.title')"
      min-width="150"
    />
    <el-table-column :label="$t('meeting.column.user')" min-width="150">
      <template #default="{ row }">
        <div v-if="!row.user">-</div>
        <template v-else>
          {{ row.user.name }}
        </template>
      </template>
    </el-table-column>

    <el-table-column
      prop="meeting_date"
      :label="$t('meeting.column.date')"
      min-width="100"
    >
      <template #default="{ row }">
        <div v-if="!row.meeting_date">-</div>
        <template v-else>
          {{ $moment(row.meeting_date).format('YYYY/MM/DD') }}
        </template>
      </template>
    </el-table-column>

    <el-table-column
      prop="location"
      :label="$t('meeting.column.location')"
      min-width="200"
    />

    <el-table-column
      prop="location_image_url"
      :label="$t('meeting.column.image_url')"
      min-width="200"
    />

    <!-- Toolbar - Start -->
    <el-table-column
      :fixed="toolbarFixed"
      :label="$t('meeting.column.options')"
      width="100"
    >
      <template #default="{ row }">
        <div class="row mx-n1 w:justify-center">
          <div class="px-1 col-auto">
            <TableButton preset="delete" @click="confirmDelete(row)" />
          </div>
        </div>
      </template>
    </el-table-column>
    <!-- Toolbar - End -->
  </el-table>
</template>

<script>
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
    },

    methods: {
      camelCase,

      async confirmDelete(row) {
        await this.$confirm('Are you sure to delete this data?')
          .then(() => {
            this.$axios.delete(`/meeting/delete/${row.id}`).then((e) => {
              this.$nuxt.refresh()
            })
          })
          .catch(() => {})
      },
    },
  }
</script>
