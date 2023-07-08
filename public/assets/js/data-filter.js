class DataFilter{
    
    constructor(url, filterHandler){
        /**
         * Contains all filter params that have been used
         */
        this.filterUrl = url;
        this.filterParams = {};
        this.filterDefault = {
            election_type: 'Election Type',
            year: 'Year',
            state: 'State',
            stage: 'Stage'
        }
        this.onFilter = filterHandler;

        let filterInstance = this;

        (document.querySelectorAll("[data-filter-type]")).forEach((item)=>{
            item.addEventListener('click', ()=>{
                let filter = event.target.getAttribute('data-filter-type');
                filterInstance.onSelectFilter(filter);
            });
        });
    }
    
    setFilterUrl(url){
        this.filterUrl = url;
    }

    /**
     * Called when a filter item is selected
     */
    onSelectFilter(filter){
        if(filter == 'year') { return; }
        let fVal = event.target.getAttribute('data-value');
        if(fVal == 'none'){
            document.querySelector('#'+filter).innerText = this.filterDefault[filter];
            delete this.filterParams[filter];
        }else{
            document.querySelector('#'+filter).innerText = event.target.innerText;
            this.filterParams[filter] = fVal;
        }
        this.filterData(this.filterParams);
        // console.log("filter params ", this.filterParams);
    }

    /**
     * Returns a particular page of filtered data
     */
    filterDataPage(page){
        this.filterData(this.filterParams, page);
    }

    /**
     * Called to get the filtered data
     */
    filterData(params, page=null){
        let filterInstance = this;
        let requestUrl = this.filterUrl;

        requestUrl += (page)? ("/" + page) : "";

        // apply filter data if any
        if(Object.keys(params).length > 0){
            requestUrl += "?";
            for(let field in params){
                requestUrl = requestUrl + field + "=" + encodeURIComponent(params[field]) + "&";
            }
            console.log("request url: " + requestUrl);
            swal.fire({
                icon: "info",
                title: "Applying Filter",
                toast: true,
                showConfirmButton: false,
                position: "bottom-right",
            });
        }
        $.ajax({
                url: requestUrl,
                type: 'GET',
                headers: {"Access-Control-Allow-Origin": "*",},            
                success: function(res) {
                    // console.log(res);
                    if(res.status){
                        swal.fire({
                            icon: "success",
                            title: "Filter Applied",
                            toast: true,
                            showConfirmButton: false,
                            position: "bottom-right",
                            timer: 1500,
                        });
                        filterInstance.onFilter(res.data);    
                    }else{
                        swal.fire({
                            icon: "error",
                            title: "Unable to apply filter",
                            toast: true,
                            showConfirmButton: false,
                            position: "bottom-right",
                            timer: 1500,
                        });
                    }                    
                },
                error: function(data){
                    swal.fire({
                        icon: "error",
                        title: "Request Failed",
                        toast: true,
                        showConfirmButton: false,
                        position: "bottom-right",
                        timer: 1500,
                    });
                    // console.log(data); 
                }
            });
    }
}
