<template>
  <Navbar>
    <template #toolbar>
      <!-- Sidebar reveal button - Start -->
      <NavbarButton class="w:block lg:w:hidden !w:ml-0" @click="toggleRevealed">
        <MenuIcon />
      </NavbarButton>
      <!-- Sidebar reveal button - End -->

      <h2 style="margin-top: 15px" class="page-title">{{ title }}</h2>
    </template>

    <!-- Navbar Menu sample -->
    <!-- <NavbarMenu to="/sample">
      Sample Menu
      <template #icon>
        <i class="el-icon-chat-line-square"></i>
      </template>
    </NavbarMenu> -->

    <!-- Language switcher - Start -->
    <NavbarDropdown trigger="click">
      {{ $t(`i18n.${localeCode}`) }}
      <template #icon>
        <font-awesome-icon :icon="['fas', 'globe']" />
      </template>
      <template #dropdown>
        <DropdownItem
          v-for="locale in $i18n.locales"
          :key="locale.code"
          @click="translate(locale)"
          >{{ $t(`i18n.${locale.code}Alt`) }}</DropdownItem
        >
      </template>
    </NavbarDropdown>
    <!-- Language switcher - End -->

    <!-- Admin menu - Start -->
    <NavbarDropdown v-if="$auth.loggedIn" trigger="click">
      {{ $auth.user.name }}
      <template #icon>
        <font-awesome-icon :icon="['fas', 'user']" />
      </template>
      <template #dropdown>
        <DropdownItem icon="el-icon-setting" to="/account">{{
          $t('navbar.label.accountSettings')
        }}</DropdownItem>
        <DropdownItem icon="el-icon-switch-button" to="/logout">{{
          $t('navbar.label.logout')
        }}</DropdownItem>
      </template>
    </NavbarDropdown>
    <!-- Admin menu - End -->

    <!-- Login button - Start -->
    <NavbarMenu v-else to="/login">
      {{ $t('navbar.label.login') }}
      <template #icon> <i class="el-icon-unlock"></i> </template>
    </NavbarMenu>
    <!-- Login button - End -->
  </Navbar>
</template>

<script>
  import { MenuIcon } from 'vue-feather-icons'
  import { mapMutations, mapState } from 'vuex'
  import {
    Navbar,
    NavbarButton,
    NavbarMenu,
    NavbarDropdown,
    NavbarDropdownItem as DropdownItem,
  } from './components/navbar'

  export default {
    components: {
      Navbar,
      MenuIcon,
      NavbarMenu,
      NavbarButton,

      NavbarDropdown,
      DropdownItem,
    },
    props: {
      title: {
        type: String,
        required: false,
        default: null,
      },
    },
    computed: {
      // Map the sidebar collapsed and revealed states
      ...mapState('sidebar', ['isCollapsed', 'isRevealed']),

      // Current locale code
      localeCode() {
        return this.$i18n.localeProperties.code
      },
    },
    methods: {
      // Map the sidebar toggle mutations
      ...mapMutations('sidebar', ['toggleCollapsed', 'toggleRevealed']),

      // Change translation
      translate(locale) {
        this.$i18n.setLocale(locale.code)
      },
    },
  }
</script>
<style scoped lang="scss">
  .page-title {
    margin-top: rem(15px);
    font-size: rem(16px);
    font-weight: bold;
  }
</style>
