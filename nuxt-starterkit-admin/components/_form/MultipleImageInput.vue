<template>
    <span>
        <el-upload
            ref="multipleUploadComponent"
            action="#"
            class="upload-demo"
            drag
            multiple
            list-type="picture"
            :limit="limit"
            :file-list="fileMultiple"
            :auto-upload="false"
            :on-change="handleChange"
            :on-exceed="handleExceed"
            prop="file"
        >
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">{{description}}</div>
            <div v-if="tooltip" slot="tip" class="el-upload__tip" >{{tooltip}}</div>
        </el-upload>
    </span>
</template>

<script>
export function multipleImageInitial() {
  return {
    file: null,
    isModified: false,
    isDeleted: false,
  };
}
export default {
  props: {
    value: {
      default: null,
      type: Object,
    },
    iserror: {
      default: false,
      type: Boolean,
    },
    isdisabled: {
      default: false,
      type: Boolean,
    },
    tooltip: {
      default: '',
      type: String,
    },
    description: {
      default: 'Drop file here or click to upload',
      type: String,
    },
    limit: {
      default: 1,
      type: Number,
    },
  },
  data() {
    return {
        fileMultiple: [],
        dialogVisible: false,
        dialogImageUrl: '',
        showUpload: true
    };
  },
  computed: {
    image: {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val);
      },
    },
  },
  methods: {
    // show modal dialog of uploaded file
    handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
    },
    // handle change event on file select
    handleChange(file, fileMultiple) {
      this.fileMultiple = fileMultiple;
      this.image = { file : fileMultiple, isModified: true, isDeleted: false };
    },
    // used to show user limit validation
    handleExceed(files, fileList) {
      this.$message.warning(`ファイルのアップロード制限は${this.limit}です, 合計${files.length}枚の画像を選択しました`);
    },
    // remove file first from file list uploaded
    handleRemove(file) {
        const uploadFileList = this.$refs.multipleUploadComponent.uploadFiles
        uploadFileList.splice(uploadFileList.indexOf(file), 1)

        // change array object of value form
        this.image = { file : null, isModified: true, isDeleted: true };

        // show upload image again
        this.toggleUpload();
    },
  },
};
</script>
