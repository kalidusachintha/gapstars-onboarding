export default {
    /**
     * Return all onboard data.
     * 
     * @returns {window.axios}
     */
    getAll() {
        return axios(`/api/getall`);
    },
}