<template>
    <li class="notification">
        <div class="media">
          <div class="media-body">
            <a href="#" class="notification-mark-read float-right" title="Marcar como leida" @click.prevent="markAsRead">
              <i class="fa fa-times" aria-hidden="true" />
            </a>
            <strong class="notification-title text-primary">
              <i :class="notification.icono"></i>
              <a :href="notification.action_url">{{ notification.title }}</a>
            </strong>

            <p class="notification-desc lh-1">
              {{ notification.empresa }}
            </p>
            <p class="notification-desc lh-1">
              {{ notification.body }}
            </p>

            <div class="notification-meta">
              <small class="timestamp">
                <timeago :since="notification.created" :auto-update="30" />
              </small>
            </div>
          </div>
        </div>
    </li>

  <!-- <li class="notification">
    <div class="media">
      <div class="media-left">
        <div class="media-object">
          <img src="/notification-icon.png">
          <i class="fas fa-concierge-bell"></i>
        </div>

      </div>

      <div class="media-body">
        <a href="#" class="notification-mark-read" title="Mark as read" @click.prevent="markAsRead">
          <i class="fa fa-times" aria-hidden="true" />
        </a>

        <strong class="notification-title">
          <a :href="notification.action_url">{{ notification.title }}</a>
        </strong>

        <p class="notification-desc">
          {{ notification.body }}
        </p>

        <div class="notification-meta">
          <small class="timestamp">
            <timeago :since="notification.created" :auto-update="30" />
          </small>
        </div>
      </div>
    </div>
  </li> -->

</template>

<script>
export default {
  props: {
    notification: {
      type: Object,
      required: true
    }
  },

  methods: {
    markAsRead () {
      this.$emit('read')
    }
  }
}
</script>
