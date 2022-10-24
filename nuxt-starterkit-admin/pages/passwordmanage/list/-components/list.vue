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
          >
            <el-option
              v-for="item in orderOptions"
              :key="item.name"
              :label="item.label"
              :value="item.name"
            ></el-option>
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
          :column="$t('password.list.website')"
          :value="row.website ? row.website : '-'"
        />
        <ListItem 
          v-if="column && column.name"
          :column="$t('password.list.username')"
          :value="row.username ? row.username : '-'"
        />
        <ListItem 
          v-if="column && column.name"
          :column="$t('password.list.password')"
          :value="row.password ? row.password : '-'"
        />
        <ListItem 
          v-if="column && column.name"
          :column="$t('password.list.site_name')"
          :value="row.site_name ? row.site_name : '-'"
        />
        <ListItem 
          v-if="column && column.name"
          :column="$t('password.list.email')"
          :value="row.email ? row.email : '-'"
        />
        <ListItem
          v-if="column && column.registrationDate"
          :column="$t('admin.list.registrationDate')"
          :value="$moment(row.created_at).format('YYYY/MM/DD')"
        />

        <div class="row w:mt-4 w:ustify-end">
          <div class="px-1 col-auto">
            <NuxtLink :to="`/passwordmanage/${row.id}/edit`">
              <TableButton preset="edit" label="編集"/>
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
  import { SuccessMsg, ErrorMsg } from '@/presets/notification/pages/form'

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
        orderInput: this.$props.direction ?? null,
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
          {name: 'website', label: 'ウェブサイトのURL'},
          {name: 'username', label: 'ユーザー名'},
          {name: 'password', label: 'パスワード'},
          {name: 'site_name', label: 'サイト名'},
          {name: 'email', label:'Email'},
        ]
      },

      ...mapState('table', {
        column: (state) => state.adminListColumn,
      })
    },

    methods: {
      camelCase,

      async deleteData(row) {
        this.isLoading = true
        const result = await this.$axios.post('/password/manage/destroy', row)
        const isSuccess = result.status === 200
        if (isSuccess) {
          this.$nuxt.refresh()
          this.$notify(SuccessMsg(this))

        } else {
          this.$notify.error(ErrorMsg(this))
        }
        this.isLoading = false
      },

      confirmDelete(row) {
        this.$confirm('Are you sure to delete this data?')
        .then(() => {
          this.deleteData(row);
        })
        .catch(() => {
        })
        
        //  a = {
        //   name:var,
        //   oo:Avatar
        //  }
        //  b {
        //   aaa:AudioParamMap,
        //   ...a
        //  }
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