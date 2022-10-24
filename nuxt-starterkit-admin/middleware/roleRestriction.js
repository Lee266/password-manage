import { snakeCase } from 'lodash'

export default function ({ app, redirect, route }) {
  // Process only when the user is authenticated
  if (app.$auth.loggedIn) {
    // The authenticated user and its role
    const user = app.$auth.user
    const userRole = snakeCase(user.role.name)

    // Identify allowed roles specified by the page
    let allowed = route.meta.reduce(
      (allowed, meta) => meta.allow || allowed,
      []
    )
    if (!Array.isArray(allowed)) allowed = [allowed]
    allowed = allowed.map(snakeCase)

    // If the user role is NOT in the allowed list
    if (allowed.length && !allowed.includes(userRole)) {
      return redirect('/login')
    }

    // Identify restricted roles specified by the page
    let restricted = route.meta.reduce(
      (restricted, meta) => meta.restrict || restricted,
      []
    )
    if (!Array.isArray(restricted)) restricted = [restricted]
    restricted = restricted.map(snakeCase)

    // If the user role is in the restricted list
    if (restricted.length && restricted.includes(userRole)) {
      return redirect('/login')
    }
  }
}
