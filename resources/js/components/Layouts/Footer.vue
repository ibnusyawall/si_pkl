<template>
    <div>
       <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; {{ env.DATE_YEARS }} <div class="bullet"></div> Design By <a href="https://instagram.com/isywl_">{{ env.AUTHOR }}</a>
        </div>
        <div class="footer-right">
          {{ env.APP_NAME }}
        </div>
      </footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                env: {
                    AUTHOR: 'Ibnu Syawal',
                    APP_NAME: 'SI PKL STMIM AKAKOM',
                    DATE_YEARS: new Date().getUTCFullYear(),
                },
            }
        },
    }
<script>
