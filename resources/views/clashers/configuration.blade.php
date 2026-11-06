@extends('layouts.app')

@section('content')

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
            <i class="fas fa-layer-group"></i>
          </div>
          <h3 class="text-base font-bold text-slate-800">  Konfigurasi Akun</h3>
          <span id="total-active" class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
            {{ $totalActive }} akun aktif
          </span>
        </div>

        <x-button
            type="button"
            variant="secondary"
            onclick="openModal('inactive-modal')">
            Akun Nonaktif

            <span id="inactive-count" class="ml-1
                    px-2 py-0.5 text-xs bg-yellow-600 rounded-full">
                {{ $inactiveClashers->count() }}
            </span>
        </x-button>

      </div>

      <div id="active-table-container">
        <div id="active-table">
          @include('clashers.partials.active-table',['clashers' => $clashers])
        </div>
      </div>

    </div>

    <x-modal
        id="inactive-modal"
        title="Akun Nonaktif"
        size="2xl">

        <div
            id="inactive-list"
            class="space-y-0"
        >

            @include(
                'clashers.partials.inactive-list',
                ['inactiveClashers' => $inactiveClashers]
            )

        </div>
        


        <x-slot:footer>

            <div class="flex justify-end">

                <button
                    type="button"
                    onclick="closeModal('inactive-modal')"
                    class="
                        px-4
                        py-2
                        text-sm
                        font-medium
                        text-slate-700
                        bg-slate-100
                        rounded-lg
                        transition-all
                        duration-200
                        hover:bg-slate-200
                        active:scale-95
                    "
                >
                    Tutup
                </button>

            </div>

        </x-slot:footer>

    </x-modal>

    <script>

      document.addEventListener('DOMContentLoaded', () => {

          const activeTable =
              document.getElementById('active-table');

          const inactiveList =
              document.getElementById('inactive-list');

          const inactiveCount =
              document.getElementById('inactive-count');

          const totalActive =
              document.getElementById('total-active');

          function showAlert(message, type = 'success')
          {
              const container =
                  document.getElementById(
                      'global-alert-container'
                  );

              if (!container) {
                  console.error(
                      'Global alert container tidak ditemukan.'
                  );

                  return;
              }

              const styles = {
                  success:
                      'bg-green-50 border-green-200 text-green-800',

                  danger:
                      'bg-red-50 border-red-200 text-red-800',

                  warning:
                      'bg-yellow-50 border-yellow-200 text-yellow-800',

                  info:
                      'bg-blue-50 border-blue-200 text-blue-800',
              };

              const alert =
                  document.createElement('div');

              alert.className = `
                  alert-message
                  border
                  rounded-lg
                  px-4
                  py-3
                  shadow-sm
                  flex
                  items-center
                  justify-between
                  opacity-0
                  -translate-y-3
                  transition-all
                  duration-300
                  ${styles[type] ?? styles.success}
              `;

              alert.innerHTML = `
                  <span>
                      ${message}
                  </span>

                  <button
                      type="button"
                      class="
                          close-alert
                          ml-4
                          text-lg
                          font-bold
                          opacity-60
                          hover:opacity-100
                      "
                  >
                      ×
                  </button>
              `;

              container.appendChild(alert);

              setTimeout(() => {
                  alert.classList.remove(
                      'opacity-0',
                      '-translate-y-3'
                  );
              }, 100);

              setTimeout(() => {
                  alert.classList.add(
                      'opacity-0',
                      '-translate-y-3'
                  );

                  setTimeout(() => {
                      alert.remove();
                  }, 300);
              }, 4000);

              alert.querySelector('.close-alert')
                  ?.addEventListener('click', () => {
                      alert.classList.add(
                          'opacity-0',
                          '-translate-y-3'
                      );

                      setTimeout(() => {
                          alert.remove();
                      }, 300);
                  });
          }

          function setLoading(form, loading)
          {
              const button =
                  form.querySelector('button');

              if (!button) {
                  return;
              }

              const normalContent =
                  button.querySelector('.button-content');

              const loadingContent =
                  button.querySelector('.loading-content');


              button.disabled = loading;

              button.classList.toggle(
                  'opacity-70',
                  loading
              );

              button.classList.toggle(
                  'cursor-not-allowed',
                  loading
              );


              normalContent?.classList.toggle(
                  'hidden',
                  loading
              );

              loadingContent?.classList.toggle(
                  'hidden',
                  !loading
              );

              loadingContent?.classList.toggle(
                  'inline-flex',
                  loading
              );
          }

          function updateUI(data) {

            if (
                activeTable &&
                data.active_html
            ) {
                activeTable.innerHTML =
                    data.active_html;
            }

            if (
                inactiveList &&
                data.inactive_html
            ) {
                inactiveList.innerHTML =
                    data.inactive_html;
            }

            if (
                totalActive &&
                typeof data.total_active !== 'undefined'
            ) {
                totalActive.textContent =
                    `${data.total_active} akun aktif`;
            }

            if (
                inactiveCount &&
                typeof data.total_inactive !== 'undefined'
            ) {
                inactiveCount.textContent =
                    data.total_inactive;
            }
          }

          document.addEventListener(
              'submit',
              async (event) => {

                  const form =
                      event.target.closest(
                          '.toggle-active-form'
                      );


                  if (!form) {
                      return;
                  }


                  event.preventDefault();


                  /*
                  * Cegah double click
                  */
                  if (
                      form.dataset.processing === 'true'
                  ) {
                      return;
                  }


                  form.dataset.processing = 'true';


                  setLoading(
                      form,
                      true
                  );


                  try {

                      /*
                      * Ambil CSRF langsung dari form
                      */
                      const csrfToken =
                          form.querySelector(
                              'input[name="_token"]'
                          )?.value;


                      if (!csrfToken) {

                          throw new Error(
                              'CSRF token tidak ditemukan.'
                          );

                      }


                      /*
                      * Pertahankan halaman pagination
                      */
                      const currentPage =
                          new URLSearchParams(
                              window.location.search
                          ).get('page') ?? 1;


                      const url =
                          new URL(
                              form.action,
                              window.location.origin
                          );


                      url.searchParams.set(
                          'page',
                          currentPage
                      );


                      /*
                      * Request AJAX
                      */
                      const response =
                          await fetch(
                              url.toString(),
                              {
                                  method: 'PATCH',

                                  headers: {
                                      'X-CSRF-TOKEN':
                                          csrfToken,

                                      'Accept':
                                          'application/json',

                                      'X-Requested-With':
                                          'XMLHttpRequest',
                                  },
                              }
                          );


                      /*
                      * HTTP Error
                      */
                      if (!response.ok) {

                          let message =
                              'Terjadi kesalahan pada server.';


                          try {

                              const error =
                                  await response.json();

                              message =
                                  error.message ??
                                  message;

                          } catch {

                              // Response bukan JSON

                          }


                          throw new Error(message);
                      }


                      /*
                      * JSON
                      */
                      const data =
                          await response.json();


                      if (!data.success) {

                          throw new Error(
                              data.message ??
                              'Gagal mengubah status akun.'
                          );

                      }


                      /*
                      * Update tabel dan jumlah
                      */
                      updateUI(data);


                      /*
                      * Tampilkan alert global
                      */
                      if (data.message) {

                          showAlert(
                              data.message,
                              'success'
                          );

                      }

                  } catch (error) {

                      console.error(
                          'Toggle active error:',
                          error
                      );

                      /*
                      * Tampilkan error melalui
                      * alert yang sama
                      */
                      showAlert(
                          error.message ??
                          'Terjadi kesalahan.',
                          'danger'
                      );

                  } finally {

                      form.dataset.processing =
                          'false';


                      setLoading(
                          form,
                          false
                      );

                  }

              }
          );

          document.addEventListener(
              'click',
              async (event) => {

                  const link =
                      event.target.closest(
                          '#active-pagination a'
                      );


                  if (!link) {
                      return;
                  }


                  event.preventDefault();


                  if (
                      link.dataset.loading === 'true'
                  ) {
                      return;
                  }


                  link.dataset.loading = 'true';


                  activeTable.classList.add(
                      'opacity-50',
                      'pointer-events-none'
                  );


                  try {

                      const response =
                          await fetch(
                              link.href,
                              {
                                  method: 'GET',

                                  headers: {
                                      'Accept':
                                          'application/json',

                                      'X-Requested-With':
                                          'XMLHttpRequest',
                                  },
                              }
                          );


                      if (!response.ok) {

                          throw new Error(
                              'Gagal memuat halaman.'
                          );

                      }


                      const data =
                          await response.json();


                      updateUI(data);


                      /*
                      * Update URL browser
                      */
                      window.history.pushState(
                          {},
                          '',
                          link.href
                      );

                  } catch (error) {

                      console.error(
                          'Pagination error:',
                          error
                      );

                      showAlert(
                          error.message ??
                          'Gagal memuat halaman.',
                          'danger'
                      );

                  } finally {

                      link.dataset.loading =
                          'false';


                      activeTable.classList.remove(
                          'opacity-50',
                          'pointer-events-none'
                      );

                  }

              }
          );

          window.addEventListener(
              'popstate',
              async () => {

                  try {

                      const response =
                          await fetch(
                              window.location.href,
                              {
                                  headers: {
                                      'Accept':
                                          'application/json',

                                      'X-Requested-With':
                                          'XMLHttpRequest',
                                  },
                              }
                          );


                      if (!response.ok) {
                          return;
                      }


                      const data =
                          await response.json();


                      updateUI(data);

                  } catch (error) {

                      console.error(
                          'History navigation error:',
                          error
                      );

                  }

              }
          );

      });

    </script>

@endsection