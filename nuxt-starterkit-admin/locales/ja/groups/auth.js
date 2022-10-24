export default {
  login: {
    page: {
      title: 'ユーザーログイン',
      submit: 'ログインする',
      forgotPassword: 'パスワードをお忘れの方',
    },
    field: {
      email: 'メールアドレス',
      password: 'パスワード',
      remember: 'ログインしたままにする',
    },
    success: {
      title: 'ログインの成功',
      message: '正常にログインしました',
    },
    error: {
      title: 'ログインエラー',
      message: 'ログインできませんでした',
    },
    invalid: {
      title: 'ログインできませんでした',
      message: '間違ったメールアドレスまたはパスワード',
    },
  },
  logout: {
    page: {
      title: 'ログアウト...',
    },
  },
  role: {
    admin: '管理者',
    superAdmin: 'スーパー管理者',
  },
  reset_password: {
    page: {
      title: 'パスワードをお忘れの方',
      text: 'パスワードをお忘れの方は、ご登録のメールアドレスを入力してください。パスワード再設定のためのメールが送信されます。',
      email: 'メールアドレス',
      submit: '送信する',
      success: 'ご登録のメールアドレスに、パスワード再設定のためのメールを送信しました。メールからパスワードの再設定を行なってください。',
    }
  },
  confirm_reset_password: {
    page: {
      title: 'パスワードの再設定',
      text: '新しいパスワードを入力してください。',
      new_password: '新しいパスワード',
      confirm_password: '新しいパスワード(もう一度入力してください)',
      submit: '再設定',
      success: 'パスワードの再設定が完了しました',
      success_text: 'ログインページから、再度ログインしてください。',
      login_here: 'ログインページはこちら',
    }
  },
}
