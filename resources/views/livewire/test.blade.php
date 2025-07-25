<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <form>
        <label for="title">{{ $variable }}</label>
        <input type="text" id="title" wire:model.live="variable">
    </form>
</div>
