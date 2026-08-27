import Sortable from 'sortablejs';

const root = document.getElementById('presentation-order');
const list = root?.querySelector('#component-list');
const saveButton = root?.querySelector('#save-order');
const message = root?.querySelector('#order-message');
const spinner = root?.querySelector('#save-spinner');
const saveLabel = root?.querySelector('#save-label');

if (root && list && saveButton && message && spinner && saveLabel) {
    const updateNumbers = () => list.querySelectorAll('.order-number')
        .forEach((number, index) => number.textContent = index + 1);

    const markChanged = () => {
        updateNumbers();
        saveButton.disabled = false;
        message.classList.add('hidden');
    };

    new Sortable(list, {
        animation: 180,
        handle: '.drag-handle',
        ghostClass: 'opacity-40',
        chosenClass: 'ring-2',
        dragClass: 'shadow-lg',
        onEnd: markChanged,
    });

    list.addEventListener('keydown', (event) => {
        const handle = event.target.closest('.drag-handle');
        if (!handle || !['ArrowUp', 'ArrowDown'].includes(event.key)) return;

        event.preventDefault();
        const item = handle.closest('[data-component]');
        const sibling = event.key === 'ArrowUp' ? item.previousElementSibling : item.nextElementSibling;
        if (!sibling) return;

        list.insertBefore(item, event.key === 'ArrowUp' ? sibling : sibling.nextElementSibling);
        markChanged();
        handle.focus();
    });

    saveButton.addEventListener('click', async () => {
        const order = [...list.querySelectorAll('[data-component]')]
            .map(item => item.dataset.component);

        saveButton.disabled = true;
        spinner.classList.remove('hidden');
        saveLabel.textContent = root.dataset.savingLabel;
        message.classList.add('hidden');

        try {
            const response = await fetch(root.dataset.storeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ order }),
            });
            if (!response.ok) throw new Error(`Request failed with status ${response.status}`);

            const data = await response.json();
            if (data.status !== 'ok') throw new Error('Unexpected response');

            message.textContent = root.dataset.successMessage;
            message.className = 'text-sm font-medium text-emerald-700 dark:text-emerald-400';
        } catch (error) {
            console.error(error);
            saveButton.disabled = false;
            message.textContent = root.dataset.errorMessage;
            message.className = 'text-sm font-medium text-red-700 dark:text-red-400';
        } finally {
            spinner.classList.add('hidden');
            saveLabel.textContent = root.dataset.saveLabel;
        }
    });
}
