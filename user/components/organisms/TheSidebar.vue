<template>
  <div>
    <b-button v-b-toggle.sidebar-1>
      Toggle Sidebar
    </b-button>
    <b-sidebar
      id="sidebar-1"
      title="Sidebar"
      shadow
    >
      <div class="px-3 py-2">
        <p>
          The Sidebar
        </p>
        <b-img
          src="https://picsum.photos/500/500/?image=54"
          fluid
          thumbnail
        />
      </div>
    </b-sidebar>
  </div>
</template>
<script>
export default {

}
</script>

<style>

</style>