<div class="max-w-max border border-blue-500 rounded p-4 divide-y" x-data="{
    step: 'installer',
    next: true,
    save: false,
    error: false,
    field: 'Install',
    status: 'Script installer',
    progress: 0,
    installer: false,
    stop: function() {
        this.installer = false;
        this.error = true;
        this.next = true;        
    },
    validation: async function() {
        if (this.next && !this.save) {
            this.installer = true;
            this.next = false;
            this.status = 'Run artisan commands';

            const commands = await $wire.runArtisanCommand();

            if (commands.error) {
                this.stop();
                return;
            }

            this.progress = 25;
            this.status = 'Installing languages';
            
            const languages = await $wire.installLanguages();
            
            if (languages.error) {
                this.stop();
                return;
            }

            this.progress = this.progress + 25;

            this.status = 'Creating user';

            const user = await $wire.createUser();

            if (user.error) {
                this.stop();
                return;
            }

            this.progress = this.progress + 20;
            this.status = 'Finishing';

            const finish = await $wire.finish();
            
            if (finish.error) {
                this.stop();
                return;
            }            

            this.progress = this.progress + 30;

            this.installer = false;

            this.next = true;

            this.status = 'Installation completed successfully';

            this.field = 'Finish';
            this.save = true;
        } else if (this.save) {
            await $wire.nextStep();
        }
    }, 
}">
    <x-install.steps />
    <div class="flex mt-4 pt-7 px-3 divide-y flex-wrap max-w-3xl flex-col">
        <x-errors :errors="$errors" />   
        <x-install.progress />
    </div>
    <x-install.next />
</div>
