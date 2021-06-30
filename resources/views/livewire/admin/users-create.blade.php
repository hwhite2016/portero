<div>
    <x-jet-danger-button>
    	Crear nuevo usuario
    </x-jet-danger-button>

    <x-jet-dialog-modal wire:model="open">
    	<x-slot name="title"></x-slot>
    	<x-slot name="content"></x-slot>
    	<x-slot name="footer"></x-slot>
    </x-jet-dialog-modal>

</div>
