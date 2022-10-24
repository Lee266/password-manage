<template>
  <li class="el-dropdown-menu__item">
    <NuxtLink
      v-if="$attrs.to"
      v-slot="{ href, navigate }"
      custom
      v-bind="$attrs"
      v-on="$listeners"
    >
      <a :href="href" class="dropdown-item-anchor" @click="navigate">
        <ul class="dropdown-item-ul">
          <el-dropdown-item
            v-bind="$attrs"
            class="dropdown-menu-item"
            v-on="$listeners"
          >
            <slot />
          </el-dropdown-item>
        </ul>
      </a>
    </NuxtLink>
    <ul v-else class="dropdown-item-ul" v-on="$listeners">
      <el-dropdown-item class="dropdown-menu-item" v-bind="$attrs">
        <slot />
      </el-dropdown-item>
    </ul>
  </li>
</template>

<script>
  export default {}
</script>

<style scoped lang="scss">
  .dropdown-item-anchor {
    display: block;
  }

  .dropdown-menu-item,
  .dropdown-item-anchor,
  .el-dropdown-menu__item ul {
    margin: rem(0 -20px);
    padding: rem(0 20px);
  }

  .dropdown-menu-item {
    transition: 0.5s easeOutExpo;
    transition-property: color, background-color;
  }
</style>
