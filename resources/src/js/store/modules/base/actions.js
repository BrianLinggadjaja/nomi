export default {
    getData (context) {
        context.commit('GET_DATA');
    },

    setList (context) {
        context.commit('SET_LIST');
    },

    setGrid (context) {
        context.commit('SET_GRID');
    },

    toggleList (context) {
        context.commit('TOGGLE_LIST');
    },

    toggleFlash (context) {
        context.commit('TOGGLE_FLASH');
    },

    toggleMenu (context) {
        context.commit('TOGGLE_MENU');
    },

    shuffleFlash (context) {
        context.commit('SHUFFLE_FLASH');
    },

    sortFirstName (context) {
        context.commit('SORT_FIRST_NAME');
        context.commit('SORT_ROSTER');
    },

    sortLastName (context) {
        context.commit('SORT_LAST_NAME');
        context.commit('SORT_ROSTER');
    },

    sortDescending (context) {
        context.commit('SORT_DESC');
        context.commit('SORT_ROSTER');
    },

    sortAscending (context) {
        context.commit('SORT_ASC');
        context.commit('SORT_ROSTER');
    },
}