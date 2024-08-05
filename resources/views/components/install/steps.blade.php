<div class="flex justify-center" x-data="{
    isActived(val) {
        return val ? ({
            text: 'text-blue-600',
            numb: 'border-blue-600 rounded-full shrink-0'
        }) : ({
            text: 'text-gray-500',
            numb: 'border-gray-500 rounded-full shrink-0'
        });
    }  
}">
    <ol class="items-center max-w-max space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
        <li class="flex items-center text-gray-500 space-x-2.5 rtl:space-x-reverse">
            <span class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0">
                1
            </span>
            <span>
                <h3 class="font-medium leading-tight">Requirements</h3>
                <p class="text-sm">Previous requirements</p>
            </span>
        </li>
        <li class="flex items-center space-x-2.5 rtl:space-x-reverse" :class="isActived(step === 'configuration').text">
            <span class="flex items-center justify-center w-8 h-8 border" :class="isActived(step === 'configuration').numb">
                2
            </span>
            <span>
                <h3 class="font-medium leading-tight">Configuration</h3>
                <p class="text-sm">Installation parameters</p>
            </span>
        </li>
        <li class="flex items-center space-x-2.5 rtl:space-x-reverse" :class="isActived(step === 'installer').text">
            <span class="flex items-center justify-center w-8 h-8 border" :class="isActived(step === 'installer').numb">
                3
            </span>
            <span>
                <h3 class="font-medium leading-tight">Installer</h3>
                <p class="text-sm">Install script</p>
            </span>
        </li> 
    </ol>
</div>