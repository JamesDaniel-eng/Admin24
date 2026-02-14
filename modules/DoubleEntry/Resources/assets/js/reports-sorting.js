/**
 * Client-side sorting for Balance Sheet and Journal reports
 * Only scopes to the report container (.my-10)
 */

let currentSort = { column: null, direction: 'asc', typeId: null };

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOMContentLoaded fired, initializing report sorting');

    // Scope to report container only
    const reportContainer = document.querySelector('.my-10');
    if (!reportContainer) {
        console.log('Report container (.my-10) not found');
        return;
    }

    addBalanceSheetSorting(reportContainer);
    addGeneralLedgerSorting(reportContainer);
    addEventListeners(reportContainer);
});

function addEventListeners(container) {
    // Use event delegation for sorting - scoped to container
    container.addEventListener('click', function (e) {
        const th = e.target.closest('th.sortable');
        if (!th) return;

        const sortType = th.getAttribute('data-sort-type');
        const headerRow = th.closest('tr');
        const typeId = headerRow.getAttribute('data-type-id');

        console.log('Sort clicked - type:', sortType, 'typeId:', typeId);

        if (sortType === 'balance-sheet') {
            sortBalanceSheetBy(headerRow, container);
        } else if (sortType === 'journal') {
            sortJournalBy(headerRow, container);
        } else if (sortType === 'general-ledger') {
            sortGeneralLedgerBy(th, headerRow, container);
        }
    });
}

function addBalanceSheetSorting(container) {
    // Find all tables within the container
    const tables = container.querySelectorAll('table');
    console.log('Found', tables.length, 'tables');

    tables.forEach((table, tableIndex) => {
        // Get the main tbody that contains account rows
        const mainTbody = table.querySelector('tbody[data-collapse^="class-"]');
        if (!mainTbody) {
            console.log('Table', tableIndex, 'skipped - no class-based tbody');
            return;
        }

        console.log('Processing table', tableIndex);

        // Get all account rows (those with both data-collapse="type-X" AND data-account-code)
        const allRows = Array.from(mainTbody.querySelectorAll('tr[data-collapse^="type-"]'));
        console.log('Table', tableIndex, 'has', allRows.length, 'rows with data-collapse');

        if (allRows.length === 0) return;

        // Group rows by typeId to detect when type changes
        const typeIds = new Set();
        allRows.forEach(row => {
            const collapse = row.getAttribute('data-collapse');
            const typeId = collapse.replace('type-', '');
            typeIds.add(typeId);
        });

        console.log('Found', typeIds.size, 'distinct types:', Array.from(typeIds).join(', '));

        // Add headers before first account of each type
        let currentTypeId = null;
        allRows.forEach((row) => {
            const collapse = row.getAttribute('data-collapse');
            const typeId = collapse.replace('type-', '');

            if (typeId !== currentTypeId) {
                currentTypeId = typeId;

                // Check if header already exists
                const prevRow = row.previousElementSibling;
                if (!prevRow || !prevRow.classList.contains('account-column-headers')) {
                    const headerRow = document.createElement('tr');
                    headerRow.className = 'account-column-headers border-t border-gray-200 bg-gray-50';
                    headerRow.setAttribute('data-type-id', typeId);
                    headerRow.innerHTML = `
                        <th class="w-10/12 ltr:text-left rtl:text-right px-3 py-2 cursor-pointer hover:bg-gray-100 transition text-xs font-semibold sortable flex items-center" data-sort-type="balance-sheet">
                            Account Code
                            <svg class="sort-indicator h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path class="sort-up" fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3z" clip-rule="evenodd" style="opacity: 0.3;"></path>
                                <path class="sort-down" fill-rule="evenodd" d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17z" clip-rule="evenodd" style="opacity: 1;"></path>
                            </svg>
                        </th>
                        <th class="w-2/12 ltr:text-right rtl:text-left px-3 py-2 text-xs font-semibold">Amount</th>
                    `;
                    row.parentNode.insertBefore(headerRow, row);
                    console.log('Added header for type', typeId);
                }
            }
        });
    });
}

function addGeneralLedgerSorting(container) {
    console.log('Initializing General Ledger sorting');

    // Find all tables within the container
    const tables = container.querySelectorAll('table');
    console.log('Found', tables.length, 'tables for General Ledger');

    tables.forEach((table, tableIndex) => {
        // Check if this table has sortable headers (General Ledger specific)
        const sortableHeaders = table.querySelectorAll('th[data-sort-type="general-ledger"]');

        if (sortableHeaders.length > 0) {
            console.log('Table', tableIndex, 'has General Ledger sortable headers');
        }
    });
}

function sortBalanceSheetBy(headerRow, container) {
    const typeId = headerRow.getAttribute('data-type-id');
    if (!typeId) {
        console.log('No type ID on header');
        return;
    }

    console.log('Sorting typeId:', typeId);

    // Find the parent tbody
    const tbody = headerRow.closest('tbody');
    if (!tbody) {
        console.log('No tbody found');
        return;
    }

    // Get ALL account rows for this type first (don't filter yet)
    const allAccountRows = Array.from(tbody.querySelectorAll(`tr[data-collapse="type-${typeId}"]`));
    console.log('Found', allAccountRows.length, 'total rows with data-collapse="type-' + typeId + '"');

    if (allAccountRows.length === 0) {
        console.log('No rows found with data-collapse="type-' + typeId + '"');
        return;
    }

    // Extract code from the td[data-account-code] element within each row
    const rows = allAccountRows.filter(row => {
        const codeTd = row.querySelector('td[data-account-code]');
        if (!codeTd) return false;
        const code = codeTd.getAttribute('data-account-code');
        const hasCode = code && code.trim() !== '';
        console.log('Row - code:', code, '- hasCode:', hasCode, '- text:', row.textContent.trim().substring(0, 50));
        return hasCode;
    });

    console.log('After filtering, have', rows.length, 'sortable rows for type', typeId);

    if (rows.length === 0) {
        console.log('No rows with codes found');
        return;
    }

    // Toggle direction if same type
    if (currentSort.typeId === typeId && currentSort.direction === 'asc') {
        currentSort.direction = 'desc';
    } else {
        currentSort.typeId = typeId;
        currentSort.direction = 'asc';
    }

    // Update all indicators in this table - dim others, highlight current
    const table = headerRow.closest('table');
    table.querySelectorAll('.account-column-headers .sort-indicator').forEach(svg => {
        svg.querySelectorAll('path').forEach(path => {
            path.style.opacity = '0.3';
        });
    });

    // Only update the current header's indicator
    const currentIndicator = headerRow.querySelector('.sort-indicator');
    const sortUpPath = currentIndicator.querySelector('.sort-up');
    const sortDownPath = currentIndicator.querySelector('.sort-down');

    if (currentSort.direction === 'asc') {
        // Ascending: show up arrow, dim down arrow
        sortUpPath.style.opacity = '1';
        sortDownPath.style.opacity = '0.3';
    } else {
        // Descending: dim up arrow, show down arrow
        sortUpPath.style.opacity = '0.3';
        sortDownPath.style.opacity = '1';
    }    // Sort by account code from the td element
    rows.sort((rowA, rowB) => {
        const codeATd = rowA.querySelector('td[data-account-code]');
        const codeBTd = rowB.querySelector('td[data-account-code]');

        const codeA = (codeATd?.getAttribute('data-account-code') || '').trim();
        const codeB = (codeBTd?.getAttribute('data-account-code') || '').trim();

        console.log('Comparing:', codeA, 'vs', codeB);
        const comparison = codeA.localeCompare(codeB, undefined, { numeric: true });
        return currentSort.direction === 'asc' ? comparison : -comparison;
    });

    // Find insertion point - right after the header
    let insertPoint = headerRow.nextElementSibling;
    console.log('Insertion point:', insertPoint?.getAttribute('data-collapse'));

    // Move each sorted row to its new position
    rows.forEach(row => {
        tbody.insertBefore(row, insertPoint);
    });

    console.log('Sorting completed for type', typeId);
}

function sortJournalBy(headerRow, container) {
    console.log('Journal sorting - not implemented yet');
}

function sortGeneralLedgerBy(sortTh, headerRow, container) {
    const sortColumn = sortTh.getAttribute('data-sort-column');
    console.log('Sorting General Ledger by:', sortColumn);

    // Find the table and its tbody
    const table = headerRow.closest('table');
    if (!table) {
        console.log('No table found');
        return;
    }

    const tbody = table.querySelector('tbody');
    if (!tbody) {
        console.log('No tbody found');
        return;
    }

    // Get all data rows in this tbody, excluding header rows (those with th elements)
    const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => {
        return row.querySelectorAll('td').length > 0; // Only rows with td elements (data rows)
    });
    console.log('Found', allRows.length, 'data rows in tbody');

    if (allRows.length === 0) {
        console.log('No data rows found');
        return;
    }

    // Toggle sort direction
    if (currentSort.column === sortColumn && currentSort.direction === 'asc') {
        currentSort.direction = 'desc';
    } else {
        currentSort.column = sortColumn;
        currentSort.direction = 'asc';
    }
    console.log('Sort direction:', currentSort.direction);

    // Get column index
    const columnIndex = getGeneralLedgerColumnIndex(sortColumn);
    console.log('Column index for', sortColumn, ':', columnIndex);

    // Sort rows
    allRows.sort((rowA, rowB) => {
        const aCell = rowA.querySelector(`td:nth-child(${columnIndex})`);
        const bCell = rowB.querySelector(`td:nth-child(${columnIndex})`);

        if (!aCell || !bCell) {
            console.log('Cell not found:', aCell, bCell);
            return 0;
        }

        let aValue = aCell.textContent.trim();
        let bValue = bCell.textContent.trim();

        // Handle numeric columns (debit, credit, balance)
        if (['debit', 'credit', 'balance'].includes(sortColumn)) {
            aValue = parseFloat(aValue.replace(/[^\d.-]/g, '')) || 0;
            bValue = parseFloat(bValue.replace(/[^\d.-]/g, '')) || 0;
            return currentSort.direction === 'asc' ? aValue - bValue : bValue - aValue;
        }

        // Handle date column
        if (sortColumn === 'date') {
            aValue = new Date(aValue);
            bValue = new Date(bValue);
            return currentSort.direction === 'asc' ? aValue - bValue : bValue - aValue;
        }

        // Handle text columns (relation, description)
        const comparison = aValue.localeCompare(bValue);
        return currentSort.direction === 'asc' ? comparison : -comparison;
    });

    // Reset all sort indicators in the thead
    const thead = table.querySelector('thead');
    if (thead) {
        thead.querySelectorAll('th.sortable .sort-indicator').forEach(svg => {
            svg.querySelectorAll('path').forEach(path => {
                path.style.opacity = '0.3';
            });
        });
    }

    // Only highlight the active column's indicator
    const activeIndicator = sortTh.querySelector('.sort-indicator');
    if (activeIndicator) {
        const sortUpPath = activeIndicator.querySelector('.sort-up');
        const sortDownPath = activeIndicator.querySelector('.sort-down');
        if (currentSort.direction === 'asc') {
            sortUpPath.style.opacity = '1';
            sortDownPath.style.opacity = '0.3';
        } else {
            sortUpPath.style.opacity = '0.3';
            sortDownPath.style.opacity = '1';
        }
    }

    // Re-insert sorted rows
    allRows.forEach(row => {
        tbody.appendChild(row);
    });

    console.log('General Ledger sorting completed for', sortColumn);
} function getGeneralLedgerColumnIndex(column) {
    const columnMap = {
        'date': 1,
        'relation': 2,
        'description': 3,
        'debit': 4,
        'credit': 5,
        'balance': 6
    };
    return columnMap[column] || 1;
}
