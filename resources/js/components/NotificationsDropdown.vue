<template>
<li ref="dropdown" class="dropdown dropdown-notifications">
    <a class="dropdown-toggle nav-link" href="#" @click.prevent="toggleDropdown">
      <i :data-count="total" class="fa fa-bell notification-icon" :class="{ 'hide-count': !hasUnread }" />
    </a>

    <div class="dropdown-container">

      <div class="dropdown-toolbar">
        <div v-show="hasUnread" class="dropdown-toolbar-actions">
          <a href="#" @click.prevent="markAllRead">Marcar como leidas</a>
        </div>

        <h3 class="dropdown-toolbar-title">
          Notificaciones ({{ total }})
        </h3>
      </div>

        <ul class="dropdown-item">
          <notification v-for="notification in notifications"
                        :key="notification.id"
                        :notification="notification"
                        @read="markAsRead(notification)"
          />

          <li v-if="!hasUnread" class="notification">
            No tiene notificaciones pendientes.
          </li>
        </ul>
        <div v-if="hasUnread" class="dropdown-footer text-center">
          <a href="/admin/notificacion/0" @click.prevent="fetch(null)">Ver todas</a>
        </div>
    </div>
</li>
</template>

<script>
import $ from 'jquery'
import axios from 'axios'
import Notification from './Notification'

export default {
  components: { Notification },

  data: () => ({
    total: 0,
    notifications: []
  }),

  computed: {
    hasUnread () {
      return this.total > 0
    }
  },

  mounted () {
    this.fetch()

    if (window.Echo) {
      this.listen()
    }

    this.initDropdown()
  },

  methods: {
    /**
     * Fetch notifications.
     *
     * @param {Number} limit
     */
    fetch (limit = 5) {
      axios.get('/notifications', { params: { limit } })
        .then(({ data: { total, notifications } }) => {
          this.total = total
          this.notifications = notifications.map(({ id, data, created }) => {
            return {
              id: id,
              title: data.title,
              icono: data.icono,
              empresa: data.empresa,
              body: data.body,
              created: created,
              action_url: data.action_url
            }
          })
        })
    },

    /**
     * Mark the given notification as read.
     *
     * @param {Object} notification
     */
    markAsRead ({ id }) {
      const index = this.notifications.findIndex(n => n.id === id)

      if (index > -1) {
        this.total--
        this.notifications.splice(index, 1)
        axios.patch(`/notifications/${id}/read`)
      }
    },

    /**
     * Mark all notifications as read.
     */
    markAllRead () {
      this.total = 0
      this.notifications = []

      axios.post('/notifications/mark-all-read')
    },

    /**
     * Listen for Echo push notifications.
     */
    listen () {
      window.Echo.private(`App.Models.User.${window.Laravel.user.id}`)
        .notification(notification => {
          this.total++
          this.notifications.unshift(notification)
        })
        .listen('NotificationRead', ({ notificationId }) => {
          this.total--

          const index = this.notifications.findIndex(n => n.id === notificationId)
          if (index > -1) {
            this.notifications.splice(index, 1)
          }
        })
        .listen('NotificationReadAll', () => {
          this.total = 0
          this.notifications = []
        })
    },

    /**
     * Initialize the notifications dropdown.
     */
    initDropdown () {
      const dropdown = $(this.$refs.dropdown)

      $(document).on('click', (e) => {
        if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0 &&
          !$(e.target).parent().hasClass('notification-mark-read')) {
          dropdown.removeClass('open')
        }
      })
    },

    /**
     * Toggle the notifications dropdown.
     */
    toggleDropdown () {
      $(this.$refs.dropdown).toggleClass('open')
    }
  }
}
</script>
