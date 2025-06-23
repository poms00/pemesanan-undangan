<div class="tw-container tw-w-full tw-p-6 tw-space-y-6 tw-mt-10 tw-mx-auto">
    <div class="tw-bg-white dark:tw-bg-gray-800 tw-rounded-lg tw-shadow tw-p-6">

        <div class="row align-items-center mb-6">
            <!-- Left: Title & Description -->
            <div class="col-12 col-md-4 text-start mb-3 mb-md-0">
                <h2 class="fs-2 fw-bold text-dark mb-1">Daftar Pengguna</h2>
                <p class="small text-secondary mb-0">Lihat dan kelola seluruh pengguna sistem.</p>
            </div>

            <div class="col-12 col-md-4 d-flex justify-content-center mb-3 mb-md-0">
                <div style="position: relative; display: flex; align-items: center; width: 400px;">
                    <div
                        style="position: absolute; left: 0.75rem; display: flex; align-items: center; pointer-events: none; z-index: 10;">
                        <svg style="width: 0.95rem; height: 0.875rem; color: #64748b;"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Search..."
                        style="width: 100%; padding: 0.5rem 2rem 0.5rem 2rem; border: 1.5px solid #e2e8f0; border-radius: 0.75rem; background: white; font-size: 0.8rem; font-weight: 400; letter-spacing: 0.02em; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); outline: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                        onFocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1), 0 5px 12px rgba(59, 130, 246, 0.1)'; this.style.transform='translateY(-1px)'"
                        onBlur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.05)'; this.style.transform='translateY(0)'"
                        onInput="toggleClearButton(this)" wire:model.live="search" />
                    @if($search)
                        <button
                            style="position: absolute; right: 0.5rem; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border: none; color: #64748b; cursor: pointer; padding: 0.25rem; border-radius: 0.75rem; transition: all 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"
                            onMouseEnter="this.style.background='linear-gradient(135deg, #e2e8f0, #cbd5e1)'; this.style.color='#475569'; this.style.transform='scale(1.05)'"
                            onMouseLeave="this.style.background='linear-gradient(135deg, #f1f5f9, #e2e8f0)'; this.style.color='#64748b'; this.style.transform='scale(1)'"
                            wire:click="$set('search', '')">
                            <svg style="width: 0.75rem; height: 0.75rem;" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Right: Button -->
            <div class="col-12 col-md-4 d-flex justify-content-end">
                <button data-bs-toggle="modal" data-bs-target="#createModal"
                    class="tw-bg-slate-600 hover:tw-bg-slate-700 tw-text-white tw-font-medium tw-py-2 tw-px-4 tw-rounded-lg tw-shadow-sm hover:tw-shadow-md tw-transition-all tw-duration-150 tw-flex tw-items-center tw-space-x-2 tw-text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Create</span>
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle" style="border-collapse: separate; border-spacing: 0 3px;">
                <thead>
                    <tr>
                        <th scope="col"
                            style="width: 8%; padding: 0.75rem 1rem; text-align: left; font-weight: 700; color: #374151; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            #</th>
                        <th scope="col"
                            style="width: 22%; padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            Nama</th>
                        <th scope="col"
                            style="width: 30%; padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            E-mail</th>
                        <th scope="col"
                            style="width: 15%; padding: 0.75rem 1rem; text-align: center;vertical-align: middle; font-weight: 600; color: #374151; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            Role</th>
                        <th scope="col"
                            style="width: 15%; padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: #374151; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            Created At</th>
                        <th scope="col"
                            style="width: 10%; padding: 0.75rem 1rem; text-align: center; font-weight: 600; color: #374151; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.025em;">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr style="background: #ffffff; border-bottom: 1px solid #e5e7eb; transition: background-color 0.25s ease-in-out;"
                            onmouseover="this.style.backgroundColor='#fff9c2';"
                            onmouseout="this.style.backgroundColor='#ffffff';">

                            <th scope="row"
                                style="padding: 0.75rem 1rem; color: #6b7280; font-weight: 500; font-size: 0.875rem;">
                                {{ $user->id }}
                            </th>

                            <td style="padding: 0.75rem 1rem; color: #111827; font-weight: 500; font-size: 0.875rem;">
                                {{ $user->name }}
                            </td>

                            <td style="padding: 0.75rem 1rem; color: #6b7280; font-size: 0.875rem;">{{ $user->email }}</td>

                            <td style="padding: 0.75rem 1rem; text-align: center; vertical-align: middle;">
                                <span style="
                                               @if($user->role === 'admin')
                                                background: linear-gradient(135deg, #7c3aed 0%, #4b5563 100%);
                                              @elseif($user->role === 'user')
                                                 background: linear-gradient(135deg, #6bbf94 0%, #3a6f60 100%);
                                            @endif
                                        color: white; 
                                        padding: 0.4rem 1rem; 
                                        border-radius: 8px; 
                                        font-size: 0.8rem; 
                                        font-weight: 500; 
                                        text-transform: capitalize; 
                                        display: inline-block;
                                    ">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>

                            <td style="padding: 0.75rem 1rem; color: #6b7280; font-size: 0.875rem;">
                                {{ $user->created_at->format('d-m-Y') }}
                            </td>

                            <td style="padding: 0.75rem 1rem; text-align: center;">
                                <div style="display: flex; justify-content: center; gap: 0.5rem;">
                                    <button data-bs-toggle="modal" data-bs-target="#editModal"
                                        wire:click="$dispatch('edit', {{ $user}})"
                                        style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; color: white; padding: 0.625rem; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(59,130,246,0.2);"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(59,130,246,0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(59,130,246,0.2)'"
                                        title="Edit User">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    wire:click="confirmUserDeletion({{ $user->id }})"
                                        style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border: none; color: white; padding: 0.625rem; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(239,68,68,0.2);"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(239,68,68,0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(239,68,68,0.2)'"
                                        title="Delete User">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"
                                style="text-align: center; padding: 3rem 1.5rem; color: #64748b; font-size: 1rem;">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                                    <svg style="width: 48px; height: 48px; color: #cbd5e1;" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                    <div class="fw-semibold text-muted">Pengguna Tidak ditemukan.</div>
                                    <div class="small text-secondary">Belum ada data untuk ditampilkan di tabel ini.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links('pagination::tailwind') }}

    </div>
    <!-- Modal for Create User -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createModalLabel">Create User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('admin.users.create')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit User -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @livewire('admin.users.edit')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delete User -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus : {{ $userIdBeingDeleted->name ?? 'User' }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteUser">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>