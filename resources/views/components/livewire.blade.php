<span>
   <livewire:is
              :component="$attributes->get('_')"
              :slot="serialize($slot)"
              :attributes="serialize($attributes)"
    />
</span>
