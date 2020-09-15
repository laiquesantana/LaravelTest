import Vue from 'vue'
import Toasted from 'vue-toasted'

Vue.use(Toasted, {
    iconPack: 'fontawesome',
    duration: 1000
})

Vue.toasted.register(
    'defaultSuccess',
    payload => !payload.msg ? 'Operation performed successfully!' : payload.msg, {
        type: 'success',
        icon: 'check'
    }
)

Vue.toasted.register(
    'defaultError',
    payload => !payload.msg ? 'Oops.. Unexpected error.' : payload.msg, {
        type: 'error',
        icon: 'times'
    }
)