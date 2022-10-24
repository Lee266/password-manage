export default {
  email: {
    required: 'メールフィールドは必須です',
    invalid: '有効なメールアドレスを入力してください',
    exist:
      'すでにシステムに登録されているメールです。別のメールを使用してください',
  },
  password: {
    required: 'パスワードフィールドは必須です',
    minLength: '{:min}文字以上入力してください',
    confirmation: 'パスワードの確認がパスワードと一致しません',
  },
  images: {
    required: '画像を選択してください'
  },

  // ---------------------------------------------------------
  // exported from laravel validation
  // ---------------------------------------------------------
  accepted: ':attributeを承認してください。',
  active_url: ':attributeは、有効なURLではありません。',
  after: ':attributeには、:date以降の日付を指定してください。',
  after_or_equal: ':attributeには、:date以降もしくは同日時を指定してください。',
  alpha: ':attributeには、アルファベッドのみ使用できます。',
  alpha_dash:
    ":attributeには、英数字('A-Z','a-z','0-9')とハイフンと下線('-','_')が使用できます。",
  alpha_num: ":attributeには、英数字('A-Z','a-z','0-9')が使用できます。",
  array: ':attributeには、配列を指定してください。',
  before: ':attributeには、:date以前の日付を指定してください。',
  before_or_equal:
    ':attributeには、:date以前もしくは同日時を指定してください。',
  between: {
    numeric: ':attributeには、:minから、:maxまでの数字を指定してください。',
    file: ':attributeには、:min KBから:max KBまでのサイズのファイルを指定してください。',
    string: ':attributeは、:min文字から:max文字にしてください。',
    array: ':attributeの項目は、:min個から:max個にしてください。',
  },
  boolean: ":attributeには、'true'か'false'を指定してください。",
  confirmed: ':attributeと:attribute確認が一致しません。',
  date: ':attributeは、正しい日付ではありません。',
  date_format: ":attributeの形式は、':format'と合いません。",
  different: ':attributeと:otherには、異なるものを指定してください。',
  digits: ':attributeは、:digits桁にしてください。',
  digits_between: ':attributeは、:min桁から:max桁にしてください。',

  dimensions: ':attributeは、正しい縦横比ではありません。',
  distinct: ':attributeに重複した値があります。',
  email_valid: ':attributeは、有効なメールアドレス形式で指定してください。',
  exists: '選択された:attributeは、有効ではありません。',
  error: 'えらーっす',
  file: ':attributeはファイルでなければいけません。',
  filled: ':attributeは必須です。',
  image: ':attributeには、画像を指定してください。',
  in: '選択された:attributeは、有効ではありません。',
  in_array: ':attributeは、:otherに存在しません。',
  integer: ':attributeには、整数を指定してください。',
  ip: ':attributeには、有効なIPアドレスを指定してください。',
  ipv4: ':attributeはIPv4アドレスを指定してください。',
  ipv6: ':attributeはIPv6アドレスを指定してください。',
  json: ':attributeには、有効なJSON文字列を指定してください。',
  max: {
    numeric: ':attributeには、:max以下の数字を指定してください。',
    file: ':attributeには、:max KB以下のファイルを指定してください。',
    string: ':attributeは、:max文字以下で入力してください。',
    array: ':attributeの項目は、:max個以下にしてください。',
  },
  mimes: ':attributeには、:valuesタイプのファイルを指定してください。',
  mimetypes: ':attributeには、:valuesタイプのファイルを指定してください。',
  min: {
    numeric: ':attributeには、:min以上の数字を指定してください。',
    file: ':attributeには、:min KB以上のファイルを指定してください。',
    string: ':attributeは、:min文字以上で入力してください。',
    array: ':attributeの項目は、:max個以上にしてください。',
  },
  not_in: '選択された:attributeは、有効ではありません。',
  numeric: ':attributeには、数字を指定してください。',
  present: ':attributeは、必ず存在しなくてはいけません。',
  regex: ':attributeはフリガナで入力してください。',
  required: ':attributeは必須項目です。',
  required_if: ':otherが:valueの場合、:attributeは必須項目です',
  required_unless: ':otherが:value以外の場合、:attributeは必須項目です',
  required_with: ':valuesが指定されている場合、:attributeも必須項目です',
  required_with_all:
    ':valuesが全て指定されている場合、:attributeも必須項目です',
  required_without: ':valuesが指定されていない場合、:attributeは必須項目です',
  required_without_all:
    ':valuesが全て指定されていない場合、:attributeは必須項目です',
  same: ':attributeと:otherが一致しません。',
  size: {
    numeric: ':attributeには、:sizeを指定してください。',
    file: ':attributeには、:size KBのファイルを指定してください。',
    string: ':attributeは、:size文字にしてください。',
    array: ':attributeの項目は、:size個にしてください。',
  },
  string: ':attributeには、文字を指定してください。',
  timezone: ':attributeには、有効なタイムゾーンを指定してください。',
  unique: '指定の:attributeは既に登録されています。',
  uploaded: ':attributeのアップロードに失敗しました。',
  url: ':attributeは、有効なURL形式で指定してください。',
  // ---------------------------------------------------------
  // exported from laravel validation
  // ---------------------------------------------------------
}
