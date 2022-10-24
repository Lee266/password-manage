# Middlewares

This folder should contain all middleware used in the project.  
Please refer to the official [`documentation`](https://nuxtjs.org/docs/directory-structure/middleware/) to read more about middleware.

### `roleRestriction.js`

This middleware processes role-based restriction defined in all page.

#### Usage example 1

```
export default {
  meta: {
    restrict: 'admin'
  }
}
```

The above example will restrict page access by an admin with the `admin` role.

#### Usage example 2

```
export default {
  meta: {
    restrict: ['admin', 'editor']
  }
}
```

The above example will restrict access from both `admin` and `editor` roles.

#### Usage example 3

```
export default {
  meta: {
    allow: ['super_admin']
  }
}
```

The abobe example will allow access to `super_admin` only.

### Sample Page

Actual usage can be found in [`admin/list`](/pages/admin/list/index.vue) page (commented out).

### Reminder

- This middleware only takes effect when the user is authenticated.  
  No checking will be done when the user has logged-out.

- You may use both `allow` and `restrict` property depending on your use case.  
  The naming-case doesn't matter. Only make sure all role name matches when being converted to [`snake_case`](https://lodash.com/docs/4.17.15#snakeCase)

Please feel free to add more middleware as you might need.
