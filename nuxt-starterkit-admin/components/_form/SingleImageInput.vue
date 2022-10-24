<template>
    <span>
        <el-upload
            ref="singleUploadComponent"
            action="#"
            list-type="picture-card"
            :limit="1"
            :multiple="false"
            :file-list="fileSingle"
            :auto-upload="false"
            :on-change="handleChange"
            prop="file"
            :class="{ hideupload: !showUpload }"
        >
            <i slot="default" class="el-icon-plus"></i>
            <div slot="file" slot-scope="{file}">
                <img
                    class="el-upload-list__item-thumbnail"
                    :src="file.url" alt=""
                >
                <span class="el-upload-list__item-actions">
                    <span
                        class="el-upload-list__item-preview"
                        @click="handlePictureCardPreview(file)"
                    >
                        <i class="el-icon-zoom-in"></i>
                    </span>
                    <span
                        v-if="!isdisabled"
                        class="el-upload-list__item-delete"
                        @click="handleRemove(file)"
                    >
                        <i class="el-icon-delete"></i>
                    </span>
                </span>
            </div>
            
            <div v-if="tooltip" slot="tip" class="el-upload__tip" >{{tooltip}}</div>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
    </span>
</template>

<script>
export function singleImageInitial() {
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
  },
  data() {
    return {
        fileSingle: [],
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
    // toogle show other upload form
    toggleUpload() {
        this.showUpload = !this.showUpload
    },
    // show modal dialog of uploaded file
    handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
    },
    // handle change event on file select
    handleChange(file, fileSingle) {
        this.fileSingle = fileSingle;
        this.image = { file, isModified: true, isDeleted: false };

        // hide other upload since this only single upload
        this.toggleUpload();
    },
    // remove file first from file list uploaded
    handleRemove(file) {
        const uploadFileList = this.$refs.singleUploadComponent.uploadFiles
        uploadFileList.splice(uploadFileList.indexOf(file), 1)

        // change array object of value form
        const nullFile = null;
        this.image = { nullFile, isModified: true, isDeleted: true };

        // show upload image again
        this.toggleUpload();
    },
  },
};
</script>
