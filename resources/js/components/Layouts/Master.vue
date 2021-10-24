<template>
    <div>
        <top-nav></top-nav>
        <side-bar></side-bar>
    </div>
</template>

<script>
    import SideBar from './SideBar'
    import TopNav from './TopNav'
    export default {
        components: {
            'side-bar': SideBar,
            'top-nav': TopNav,
        }
    }
</script>
