<template>
  <p>Twitterへリダイレクトしています</p>
</template>

<script>
export default {
  middleware: 'guest',

  

  mounted () {
    window.location.href = '/oauth/twitter'
  }
}
</script>