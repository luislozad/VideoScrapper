<div class="mt-20" x-data="{
    step: 'configuration',
    next: false,
    handleStep: function(step) {
        this.step = step;
    },
    handleNext: function(val) {
        this.next = val;
    }
}">
    <div class="p-5 flex justify-center">
        {{ $slot }}
    </div>
</div>