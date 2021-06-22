
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const webservices = require('./webservices')();
export const store = new Vuex.Store({
    state: {
       user: {
           name: null,
           lastName: null,
           email: null,
           filters: null,
           _token: null,
           role: null
       },  
       loading: true,
       loadingBody: true
    },
    getters: {

    },
    mutations: {
        updateUser(state,payload){
            state.user.id = payload.id;
            state.user.name = payload.name;
            state.user.lastName = payload.lastName;
            state.user.email = payload.email;
            state.user.filters = payload.filters;
            state.user.role = payload.role;
        },
        updateFiltersUser(state, payload) {
            state.user.filters = payload;
        },
        setLoading(state, loading){
            state.loading = loading;
        },
        setLoadingBody(state, loadingBody){
            state.loadingBody = loadingBody;
        }
    },
    actions: {
        updateUser({commit}, payload){
           commit('updateUser',payload)
       },
       updateFiltersUser({commit}, payload){
           commit('updateFiltersUser',payload)
       },
        setLoading({commit}, payload){
            commit('setLoading',payload)
        },
        setLoadingBody({commit}, payload){
            commit('setLoadingBody', payload);
        },
        getUserInfo({commit}){
            commit('setLoading', true);
            return webservices.getUserInfo().then((response) => {
                commit('updateUser', response.data);
                commit('setLoading', false);
            }).finally(() => {
            })
        },
        dataCharge({commit}){
            commit('setLoadingBody', false);
        },
        initdataCharge({commit}){
            commit('setLoadingBody', true);
        }
    }
});
