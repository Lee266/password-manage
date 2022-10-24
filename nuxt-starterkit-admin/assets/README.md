# Assets Folder

This is a Nuxt generated folder.  
The assets folder should contain all assets (dynamic assets) used by the project.

### `assets/scss`

This folder contains SASS/SCSS files used by the app.
In this folder we have 2 different scss files. The

#### `assets/scss/global.scss`

This will generate global CSS.  
Internally we have custom CSS as well as Override CSS that is targeted to override several styling in the page.

#### `assets/scss/import.scss`

This file will NOT generate any CSS styling. This file is used as import from any component.  
By importing this file, you will have access to some SASS mixins we have in the [`mixins`](/assets/scss/mixins) folder.
Such as the breakpoint mixin.

To see how the mixins are used in a component, you may refer to the usage in the [`Admin Layout`](/layouts/admin.vue) component.
