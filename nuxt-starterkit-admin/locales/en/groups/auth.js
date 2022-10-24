export default {
  login: {
    page: {
      title: 'User Login',
      submit: 'Sign In',
      forgotPassword: 'Forgot your password?',
    },
    field: {
      email: 'Email',
      password: 'Password',
      remember: 'Remember me',
    },
    success: {
      title: 'Login Success',
      message: 'You have been successfully logged in',
    },
    error: {
      title: 'Login Error',
      message: 'Sorry, we cannot log you in',
    },
    invalid: {
      title: 'Login Failed',
      message: 'Incorrect email address or password',
    },
  },
  logout: {
    page: {
      title: 'Logging out ...',
    },
  },
  role: {
    admin: 'Admin',
    superAdmin: 'Super Admin',
  },
  reset_password: {
    page: {
      title: 'Forgot your password?',
      text: 'Please enter your email. You can receive the email for resetting your password.',
      email: 'Email',
      submit: 'Send Password Reset Link',
      success: 'The reset password email has been sent! You can reset your password from the received email. Thank you!',
    }
  },
  confirm_reset_password: {
    page: {
      title: 'Reset your password',
      text: 'Please enter your new password',
      new_password: 'Your new password',
      confirm_password: 'Please enter your new password again',
      submit: 'Reset',
      success: 'Your password has been updated.',
      success_text: 'You can log in here',
      login_here: 'Log in page here',
    }
  },
}
