const axios = require('axios').default;

module.exports = () => ({
    /*************     User      *********************/
    getUserInfo: () => new Promise((resolve, reject) =>
        axios
            .get(`/admin/user-info`)
            .then(response => {
                const {data} = response.data;
                resolve({data});
            })
            .catch(reject)
    ),

});
