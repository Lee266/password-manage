# Components Folder

This folder should contain general components shared between pages within this app.  
Please head over to the Nuxt component [documentation](https://nuxtjs.org/docs/directory-structure/components/) to read more.

## When porting components from other projects

If you need to transfer components created in other projects to the Nuxt starter kit, store them in this folder.

## Current Components

By default, components are not auto-loaded.  
This way your page can efficiently load only components related/needed by the page.  
To auto-load all components, you can uncomment the `components: true` option in [`nuxt.config.js`](/nuxt.config.js)

### `components/form`

This folder contains components related to form elements.

### `components/table`

This folder contains components related to table / data list elements.  
Usage of these components can be found in the [`admin/list`](/pages/admin/list/index.vue) page.

### `components/button`

This folder contains custom button components.  
You may remove each component you no longer need and add new components as many as you wish.
