var AitShippingMethod = Class.create(Step,  
    {
        initShippingMethod: function(shippingMethodContainerId)
        {
            this.initEvents(shippingMethodContainerId);
        },

        afterInit: function()
        {
            this.initShippingMethod(this.ids.loadContainer);

            if (aitCheckout.getStep('shipping'))
            {
                aitCheckout.getStep('shippinglocation').setReloadSteps(['shipping_method']);
            }
            else
            {
                aitCheckout.getStep('billinglocation').setReloadSteps(['shipping_method']);
                aitCheckout.getStep('billinglocation').initVirtualUpdate();
            }

            this.setReloadSteps(['payment', 'review']);
        }
    });