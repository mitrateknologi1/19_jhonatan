<select wire:model.change="perpage" class="select select-bordered w-auto">
    <option @selected($perpage == 5) class="5">5</option>
    <option @selected($perpage == 10) class="10">10</option>
    <option @selected($perpage == 20) class="20">20</option>
    <option @selected($perpage == 50) class="50">50</option>
</select>
