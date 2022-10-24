<template>
  <Sidebar>
    <template #header>
      <SidebarHeader> Nuxt Starterkit </SidebarHeader>
    </template>

    <SidebarGroup>
      <!-- With description -->
      <!-- Can be supplied as attribute or as slot #description -->
      <SidebarMenu to="/dashboard" :label="$t('sidebar.label.dashboard')">
        <template #icon>
          <font-awesome-icon :icon="['fas', 'house-chimney']" />
        </template>
      </SidebarMenu>

      <!-- Label can be supplied as attribute or default slot -->
      <!--
        Reminder: When supplied as slot, the menu tooltip will not be reactive to i18n updates
        You may provide a separate tooltip content when supplying label as slot.
      -->
      <SidebarMenu to="/user" :label="$t('sidebar.label.users')">
        <template #icon>
          <font-awesome-icon :icon="['fas', 'user']" />
        </template>
        <template #submenu>
          <SidebarMenu to="/user/list" :label="$t('sidebar.label.user.list')">
            <template #icon>
              <font-awesome-icon :icon="['fas', 'list']" />
            </template>
          </SidebarMenu>
          <SidebarMenu
            to="/user/create"
            :label="$t('sidebar.label.user.create')"
          >
            <template #icon>
              <font-awesome-icon :icon="['fas', 'plus']" />
            </template>
          </SidebarMenu>
          <SidebarMenu to="/sample/form" :label="$t('sidebar.label.admin.log')">
            <template #icon>
              <font-awesome-icon :icon="['fas', 'clock-rotate-left']" />
            </template>
          </SidebarMenu>
        </template>
      </SidebarMenu>

      <!-- Icon can be supplied as attribute or slot #icon -->
      <!-- When not supplied, the label abbreviation will be used as icon -->
      <SidebarMenu to="/admin" :label="$t('sidebar.label.admins')">
        <template #icon>
          <font-awesome-icon :icon="['fas', 'user-gear']" />
        </template>
        <template #submenu>
          <SidebarMenu to="/admin/list" :label="$t('sidebar.label.admin.list')">
            <template #icon>
              <font-awesome-icon :icon="['fas', 'id-card']" />
            </template>
          </SidebarMenu>

          <SidebarMenu
            to="/admin/create"
            :label="$t('sidebar.label.admin.create')"
          >
            <template #icon>
              <font-awesome-icon :icon="['fas', 'user-plus']" />
            </template>
          </SidebarMenu>

          <SidebarMenu
            to="/activity/logs"
            :label="$t('sidebar.label.admin.log')"
          >
            <template #icon>
              <font-awesome-icon :icon="['fas', 'clock-rotate-left']" />
            </template>
          </SidebarMenu>
        </template>
      </SidebarMenu>

      <!-- Icon can be supplied as attribute or slot #icon -->
      <!-- When not supplied, the label abbreviation will be used as icon -->
      <SidebarMenu to="/meeting" :label="$t('sidebar.label.meetings')">
        <template #icon>
          <font-awesome-icon :icon="['fas', 'people-group']" />
        </template>
        <template #submenu>
          <SidebarMenu
            to="/meeting/list"
            :label="$t('sidebar.label.meeting.list')"
          >
            <template #icon>
              <font-awesome-icon :icon="['fas', 'people-group']" />
            </template>
          </SidebarMenu>
        </template>
      </SidebarMenu>

      <SidebarMenu to="/passwordmanage" :label="$t('sidebar.label.passwordManages')">
        <template #submenu>
          <SidebarMenu to="/passwordmanage/list" :label="$t('sidebar.label.passwordManage.list')">
            <template #icon>
              <font-awesome-icon :icon="['fas', 'list']" />
            </template>
          </SidebarMenu>
          <SidebarMenu
            to="/passwordmanage/create"
            :label="$t('sidebar.label.passwordManage.create')"
          >
            <template #icon>
              <font-awesome-icon :icon="['fas', 'plus']" />
            </template>
          </SidebarMenu>
        </template>
      </SidebarMenu>
      

      <!-- Nested menus -->
      <!--
      <SidebarMenu to="/sample/form" icon="fs">{{
        $t('sidebar.label.formSample')
      }}</SidebarMenu>
      -->

      <!-- Label can be supplied as attribute or default slot -->
      <!--
      <SidebarMenu to="/activity" :label="$t('sidebar.label.activityLogs')">
        <template #icon>
          <font-awesome-icon :icon="['fas', 'people-group']" />
        </template>
        <template #submenu>
          <SidebarMenu to="/activity/logs">
            <template #icon>
              <font-awesome-icon :icon="['fas', 'people-group']" />
            </template>
            {{ $t('sidebar.label.activityLog.admin') }}
          </SidebarMenu>
        </template>
      </SidebarMenu>
      -->

      <!-- With badge -->
      <!-- You can also supply badge as attribute or slot #badge -->
      <!-- <SidebarMenu to="/news" badge="5" icon="n">News</SidebarMenu> -->

      <!-- With feather icon -->
      <!-- https://vue-feather-icons.egoist.sh -->
      <!-- <SidebarMenu to="/settings">
        Settings
        <template #description>Site settings</template>
        <template #icon>
          <settings-icon size="1x" />
        </template>
      </SidebarMenu> -->
    </SidebarGroup>

    <!-- You may also add more group -->
    <!-- <SidebarGroup title="more samples">
      <SidebarMenu to="/layouts" label="Layout">
        <template #icon>
          <i class="el-icon-notebook-2"></i>
        </template>
        <template #submenu>
          <SidebarMenu to="/layouts/admin" icon="adl">Admin Layout</SidebarMenu>
          <SidebarMenu to="/layouts/auth" icon="au">Auth Layout</SidebarMenu>
        </template>
      </SidebarMenu>
    </SidebarGroup> -->

    <!-- Copyright - Start -->
    <template #copyright>{{ copyright }}</template>
    <!-- Copyright - End -->
  </Sidebar>
</template>

<script>
  import { mapState } from 'vuex'

  import {
    Sidebar,
    SidebarHeader,
    SidebarGroup,
    SidebarMenu,
  } from './components/sidebar'

  export default {
    components: {
      Sidebar,
      SidebarGroup,
      SidebarMenu,
      SidebarHeader,
    },

    computed: {
      ...mapState('sidebar', ['copyright']),
    },
  }
</script>

<style scoped lang="scss">
  .copyright {
    position: fixed;
    bottom: rem(15px);
    font-size: rem(10px);
    padding: rem(0 15px);
  }
</style>
