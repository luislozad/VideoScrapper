<div class="max-w-sm flex flex-wrap">
    <div class="w-full">
        <h6 class="text-base font-bold border-b mb-3 border-gray-300">Administration</h6>
        <div class="mb-5">
            <label for="appName" class="block mb-2 text-sm font-medium text-gray-900">App Name</label>
            <input type="text" id="appName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.appName" required :value="db.appName">
          </div>        
          <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.email" required :value="db.email">
          </div>
        <div class="mb-5">
          <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
          <input type="text" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.username" required :value="db.username">
        </div>
        <div class="mb-5">
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
          <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.password" required :value="db.password">
        </div>
    </div>

    <div class="w-full">
        <h6 class="text-base font-bold border-b mb-3 border-gray-300">Database</h6>
        <div class="mb-5">
            <label for="host" class="block mb-2 text-sm font-medium text-gray-900">Host</label>
            <input type="email" id="host" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.hostDB" required :value="db.hostDB">
        </div>
        <div class="mb-5">
            <label for="port" class="block mb-2 text-sm font-medium text-gray-900">Port</label>
            <input type="email" id="port" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.portDB" required :value="db.portDB">
        </div>  
        <div class="mb-5">
            <label for="database" class="block mb-2 text-sm font-medium text-gray-900">Database Name</label>
            <input type="email" id="database" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.database" required :value="db.database">
        </div>         
        <div class="mb-5">
            <label for="usernameDB" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
            <input type="email" id="usernameDB" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.usernameDB" required :value="db.usernameDB">
        </div>   
        <div class="mb-5">
            <label for="passwordDB" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
            <input type="email" id="passwordDB" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" x-model="db.passwordDB" required :value="db.passwordDB">
        </div>                       
    </div>    
</div>