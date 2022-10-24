<template>
    <Page title="パスワード一覧" :breadcrumbs="breadcrumbs">
        <h1>Hello world</h1>
    </Page>
</template>

<script>
    import Page from '@/layouts/admin'
    export default {
        components: {
            Page,
        },
        data: () => ({
            breadcrumbs: [{ to: '/dashboard', label: 'ダッシュボード' }],
        }),
    }
</script>