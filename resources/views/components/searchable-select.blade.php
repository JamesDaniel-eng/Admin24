@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option...',
])

<div 
    x-data="searchableSelectComponent()"
    @init="init()"
    data-options='@json($options)'
    data-selected='@json($selected)'
    data-id="{{ $id }}"
    data-name="{{ $name }}"
    data-placeholder="{{ $placeholder }}"
    class="pot-form-group">
    @if($label)
        <label for="{{ $id }}" class="block font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif
    
    <div class="relative">
        <!-- Hidden input for form submission -->
        <input type="hidden" x-model="selected" name="{{ $name }}" id="{{ $name }}">
        
        <!-- Search/Display Input -->
        <input
            type="text"
            id="{{ $id }}"
            x-ref="searchInput"
            @input="filterOptions()"
            @click="toggleDropdown()"
            @keydown.escape="closeDropdown()"
            @keydown.arrow-down.prevent="selectNext()"
            @keydown.arrow-up.prevent="selectPrev()"
            @keydown.enter.prevent="selectCurrent()"
            :placeholder="placeholder"
            class="w-full px-3 py-2 pr-5 text-sm border border-gray-300 rounded-md shadow-sm cursor-pointer"
            autocomplete="off"
        />
        
        <!-- Chevron Icon -->
        <div class="absolute right-1 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
            <i class="material-icons text-lg" :class="isOpen ? 'rotate-180' : ''">expand_more</i>
        </div>
        
        <!-- Dropdown Options -->
        <div
            x-show="isOpen && filtered.length > 0"
            @click.away="closeDropdown()"
            :style="dropdownStyle"
            class="absolute z-50 w-full bg-white border border-gray-300 rounded-md shadow-2xl scrollbar-hide hover:scrollbar-hover"
            style="max-height: 230px; overflow-y: scroll;"
        >
            <div class="py-1">                
                <template x-for="(option, index) in filtered" :key="option.id">
                    <div
                        @click="!isOptionDisabled(option) && selectOption(option)"
                        :class="[
                            index === highlightedIndex && !isOptionDisabled(option) ? 'bg-blue-500 text-white' : isOptionDisabled(option) ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-900 hover:bg-gray-100 cursor-pointer'
                        ]"
                        class="px-3 py-2 text-sm transition-colors cursor-pointer searchable-select-option"
                        @mouseenter="checkAndStartMarquee($event)"
                    >
                        <span x-text="option.label" class="block whitespace-nowrap searchable-select-text"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<style>
.pot-form-group i.material-icons {
    transition: transform 0.2s ease;
}

.searchable-select-option {
    position: relative;
    overflow: hidden;
    min-height: 28px;
    display: flex;
    align-items: center;
}

.searchable-select-text {
    display: inline-block;
    line-height: 1.2;
}

.searchable-select-option:not(:hover) .searchable-select-text {
    overflow: hidden;
    text-overflow: ellipsis;
}

.searchable-select-option:hover .searchable-select-text.is-truncated {
    animation: selectMarquee linear infinite;
}

@keyframes selectMarquee {
    0% {
        transform: translateX(0);
    }
    var(--scroll-percent) {
        transform: translateX(calc(-1 * var(--scroll-distance, 0px)));
    }
    100% {
        transform: translateX(calc(-1 * var(--scroll-distance, 0px)));
    }
}

/* Hide scrollbar but keep scrolling functionality */
.scrollbar-hide {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.scrollbar-hide::-webkit-scrollbar {
    display: none; /* Chrome, Safari, and Opera */
}

/* Alternative: Show scrollbar only on hover (floating style) */
.scrollbar-hover::-webkit-scrollbar {
    width: 6px !important;
}

.scrollbar-hover::-webkit-scrollbar-track {
    background: transparent !important;
}

.scrollbar-hover::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2) !important;
    border-radius: 3px !important;
}

.scrollbar-hover::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.4) !important;
}
</style>

<script>
window.searchableSelectComponent = function() {
    return {
        options: [],
        selected: '',
        inputId: '',
        inputName: '',
        placeholder: 'Select an option...',
        isOpen: false,
        searchQuery: '',
        filtered: [],
        highlightedIndex: 0,
        dropdownStyle: {},
        
        init() {
            // Read from data attributes
            this.options = JSON.parse(this.$el.dataset.options || '[]');
            this.selected = this.$el.dataset.selected || '';
            this.inputId = this.$el.dataset.id || '';
            this.inputName = this.$el.dataset.name || '';
            this.placeholder = this.$el.dataset.placeholder || 'Select an option...';
            
            if (this.selected === 'null' || this.selected === 'null') {
                this.selected = '';
            }
            
            // Initialize filtered list with a copy of options
            this.filtered = [...this.options];
            
            // Set display value if something is selected
            if (this.selected && this.$refs.searchInput) {
                const selectedOption = this.options.find(opt => opt.id == this.selected);
                if (selectedOption) {
                    this.$refs.searchInput.value = selectedOption.label;
                }
            }
            
            // Listen for sourceWarehouseChanged event to update disabled options
            this.$el.addEventListener('sourceWarehouseChanged', () => {
                this.$nextTick(() => {
                    this.filterOptions(); // Refilter to update visuals
                });
            });
        },
        
        openDropdown() {
            if (!this.isOpen) {
                this.isOpen = true;
                this.searchQuery = '';
                this.filtered = [...this.options];
                
                // Highlight the currently selected option
                if (this.selected) {
                    const selectedIndex = this.filtered.findIndex(opt => opt.id == this.selected);
                    this.highlightedIndex = selectedIndex >= 0 ? selectedIndex : 0;
                } else {
                    this.highlightedIndex = 0;
                }
                
                this.$nextTick(() => this.updateDropdownPosition());
            }
        },
        
        closeDropdown() {
            this.isOpen = false;
            this.searchQuery = '';
            if (this.$refs.searchInput) {
                const selectedOption = this.options.find(opt => opt.id == this.selected);
                this.$refs.searchInput.value = selectedOption ? selectedOption.label : '';
            }
            this.filtered = [...this.options];
            this.highlightedIndex = 0;
        },
        
        toggleDropdown() {
            if (this.isOpen) {
                this.closeDropdown();
            } else {
                this.openDropdown();
            }
        },
        
        updateDropdownPosition() {
            this.$nextTick(() => {
                const rect = this.$refs.searchInput.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const dropdownHeight = 230;
                const spaceBelow = viewportHeight - rect.bottom;
                const spaceAbove = rect.top;
                
                if (spaceBelow >= dropdownHeight + 20) {
                    // Show below
                    this.dropdownStyle = {
                        top: '100%',
                        left: '0',
                        marginTop: '12px'
                    };
                } else if (spaceAbove >= dropdownHeight + 20) {
                    // Show above
                    this.dropdownStyle = {
                        bottom: '100%',
                        left: '0',
                        marginBottom: '12px'
                    };
                } else {
                    // Default to below
                    this.dropdownStyle = {
                        top: '100%',
                        left: '0',
                        marginTop: '12px'
                    };
                }
            });
        },
        
        filterOptions() {
            this.searchQuery = this.$refs.searchInput.value.toLowerCase();
            if (this.searchQuery.length === 0) {
                this.filtered = [...this.options];
            } else {
                this.filtered = this.options.filter(option => 
                    option.label.toLowerCase().includes(this.searchQuery)
                );
            }
            this.highlightedIndex = 0;
            if (this.isOpen) {
                this.updateDropdownPosition();
            }
        },
        
        selectOption(option) {
            this.selected = option.id;
            if (this.$refs.searchInput) {
                this.$refs.searchInput.value = option.label;
            }
            this.closeDropdown();
            
            // Find and trigger change event on the hidden input for form processing
            const hiddenInput = document.querySelector(`input[name="${this.inputName}"]`);
            if (hiddenInput) {
                // Create a custom change event with the selected value in the detail
                const event = new CustomEvent('change', { 
                    bubbles: true,
                    detail: {
                        name: this.inputName,
                        value: option.id,
                        label: option.label
                    }
                });
                hiddenInput.dispatchEvent(event);
            }
        },
        
        selectNext() {
            if (this.highlightedIndex < this.filtered.length - 1) {
                this.highlightedIndex++;
            }
        },
        
        selectPrev() {
            if (this.highlightedIndex > 0) {
                this.highlightedIndex--;
            }
        },
        
        selectCurrent() {
            if (this.filtered.length > 0 && !this.isOptionDisabled(this.filtered[this.highlightedIndex])) {
                this.selectOption(this.filtered[this.highlightedIndex]);
            }
        },
        
        isOptionDisabled(option) {
            // Check if this option is disabled via data attribute from pot.js
            const disabledId = this.$el.dataset.disabledId;
            return disabledId && option.id == disabledId;
        },
        
        checkAndStartMarquee(event) {
            const textSpan = event.currentTarget.querySelector('.searchable-select-text');
            const container = event.currentTarget;
            
            if (!textSpan) return;
            
            // Check if text is truncated (overflowing)
            const isOverflowing = textSpan.scrollWidth > container.offsetWidth;
            
            if (isOverflowing) {
                textSpan.classList.add('is-truncated');
                // Calculate scroll distance: scroll until 10px gap from right edge
                const scrollDistance = textSpan.scrollWidth - (container.offsetWidth - 10);
                const scrollTime = (scrollDistance / 50) * 1000; // Time to scroll in milliseconds
                const pauseTime = 3000; // 3 second pause after scrolling
                const totalDuration = scrollTime + pauseTime;
                const scrollPercent = (scrollTime / totalDuration) * 100;
                
                textSpan.style.setProperty('--scroll-distance', scrollDistance + 'px');
                textSpan.style.setProperty('--scroll-percent', scrollPercent);
                textSpan.style.animationDuration = totalDuration + 'ms';
            } else {
                textSpan.classList.remove('is-truncated');
            }
        }
    };
};
</script>
