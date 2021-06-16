
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
       user: {
           name: null,
           lastName: null,
           email: null,
           _token: null
       }
    },
    getters: {

    },
    mutations: {
        updateUser(state,payload){
            state.user.id = payload.id;
            state.user.name = payload.name;
            state.user.lastName = payload.lastName;
            state.user.email = payload.email;
        },
        setToken(state, payload){
           state.user._token = payload
        }

    },
    actions: {
        updateUser({commit}, payload){
           commit('updateUser',payload)
       },
        setToken({commit}, payload){
            commit('setToken', payload)
        }
    }
});
