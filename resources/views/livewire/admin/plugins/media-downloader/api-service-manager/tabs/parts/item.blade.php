@props([
    'id' => 'tabModalDanger',

    'list' => '[]',

    'openModalDanger' => 'null',
    'onItemUpdate' => 'null',
])

<template x-for="item in {{$list}}" :key="item.id">
    <tr x-sort:item="item">
        <th style="text-align: center; vertical-align: middle;" x-sort:handle>
            <div class="btn-drag">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-grip-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
            </div>
        </th>
        <td> <input type="text" class="form-control" placeholder="key" x-model="item.key" @input="{{$onItemUpdate}}"/></td>
        <td> <input type="text" class="form-control" placeholder="value" x-model="item.value" @input="{{$onItemUpdate}}"/></td>
        <td style="text-align: center; vertical-align: middle;">
            <div class="btn-a" type="button" data-bs-toggle="modal" data-bs-target="#{{$id}}" @click="{{$openModalDanger}} ? {{$openModalDanger}}(item.id, '{{$list !== '[]' ? $list : 'null'}}') : null">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>                
            </div>
        </td>
      </tr>
</template>
