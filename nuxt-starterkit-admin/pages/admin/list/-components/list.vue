<template>
  <div class="w:mt-4">
    <div class="row">
      <div class="col-8">
        <el-select
          v-model="orderInput"
          class="w:w-full"
          placeholder="Select Order"
          clearable
          filterable
          @change="filterOrder"
        >
          <el-option
            v-for="item in orderOptions"
            :key="item.name"
            :label="item.label"
            :value="item.name"
          />
        </el-select>
      </div>
      <div class="col-4">
        <el-select
          v-model="directionInput"
          class="w:w-full"
          placeholder="Select Order Direction"
          clearable
          filterable
          :disabled="!orderInput"
          @change="filterDirection"
        >
          <el-option value="asc" label="Ascending"></el-option>
          <el-option value="desc" label="Descending"></el-option>
        </el-select>
      </div>
    </div>
    <div v-for="row in data" :key="row.id">
      <el-card v-loading="loading" class="w:mt-4">
        <ListItem
          v-if="column && column.name"
          :column="$t('admin.list.name')"
          :value="row.name ? row.name : '-'"
        />
        <ListItem
          v-if="column && column.role"
          :column="$t('admin.list.authority')"
          :value="row.role ? row.role.name : '-'"
        />
        <ListItem
          v-if="column && column.email"
          :column="$t('admin.list.email')"
          :value="row.email"
        />
        <ListItem
          v-if="column && column.company"
          :column="$t('admin.list.companyName')"
          :value="row.company ? row.company.name : '-'"
        />
        <ListItem
          v-if="column && column.telpNumber"
          :column="$t('admin.list.telpNumber')"
          :value="row.company ? row.company.phone : '-'"
        />
        <ListItem
          v-if="column && column.residence"
          :column="$t('admin.list.residence')"
          :value="row.company ? row.company.address : '-'"
        />
        <ListItem
          v-if="column && column.registrationDate"
          :column="$t('admin.list.registrationDate')"
          :value="$moment(row.created_at).format('YYYY/MM/DD')"
        />
        <div class="row w:mt-4 w:justify-end">
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
      </el-card>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import { camelCase } from 'lodash'
  import { TableButton } from '@/components/table'
  import ListItem from '@/components/list/item'

  export default {
    components: {
      TableButton,
      ListItem,
    },
    props: {
      data: { type: Array, default: () => [] },
      page: { type: [String, Number], default: 1 },
      order: { type: String, default: null },
      direction: { type: String, default: null },
      resources: { type: Object, default: () => {} },
      loading: { type: Boolean, default: false },
    },
    data() {
      return {
        sortSelected: null,
        orderInput: this.$props.order ?? null,
        directionInput: this.$props.direction ?? null,
      }
    },
    computed: {
      routeName() {
        return this.$route.name
      },
      routeQuery() {
        return this.$route.query
      },
      orderOptions() {
        return [
          { name: 'name', label: '管理者名' },
          { name: 'role', label: '管理者権限' },
          { name: 'email', label: 'メールアドレス' },
          { name: 'company', label: '会社名' },
        ]
      },

      ...mapState('table', {
        column: (state) => state.adminListColumn,
      }),
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

      filterOrder(value) {
        const order = value || undefined
        const query = { ...this.routeQuery, ...{ order, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },

      filterDirection(value) {
        const direction = value || undefined
        const query = { ...this.routeQuery, direction }
        this.$router.push({ name: this.routeName, query })
      },
    },
  }
</script>
