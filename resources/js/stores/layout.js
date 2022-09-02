export default {
    namespaced: true,
    state:{
        application_name: 'ePrescription',
        application_logo: require('@/assets/images/logo.webp'),
    },
    getters:{
        application_name: (state) => state.application_name,
        application_logo: (state) => state.application_logo,
    },
    actions:{
        setPageTitle({dispatch, state}, pageTitle){
            return new Promise(
                (resolve, reject) => {

                    var siteTitle = state.application_name;
                    if(siteTitle){
                        pageTitle += ` - ${siteTitle}`;
                    }
                    document.title = pageTitle;

                    resolve(true)
                }
            )
        }
    }
}
