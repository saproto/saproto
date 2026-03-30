
<template>
  <nav
    class="flex fixed inset-x-0 top-0 flex-wrap justify-between items-center py-2 px-0 leading-6 bg-lime-500 text-neutral-800 xl:flex-nowrap xl:justify-start"
    style="z-index: 1030; border-spacing: 0px; list-style: outside;"
  >
    <div
      class="flex justify-between items-center px-3 mx-auto w-full text-neutral-800"
      style="border-spacing: 0px; list-style: outside;"
    >
      <a
        class="py-1 mr-4 text-xl leading-7 text-white whitespace-nowrap cursor-pointer"
        href="https://www.proto.utwente.nl"
        style="text-decoration: none; border-spacing: 0px; list-style: outside;"
      >
        S.A. Proto
      </a>

      <button
        class="py-1 px-3 m-0 text-xl leading-none text-center text-white normal-case bg-transparent rounded-md border border-white border-solid cursor-pointer xl:hidden"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar"
        aria-controls="navbar"
        aria-expanded="false"
        aria-label="Toggle navigation"
        style="transition: none; outline: none; border-spacing: 0px; list-style: outside;"
      >
        <span
          class="inline-block w-6 h-6 leading-5 align-middle bg-no-repeat"
          style="background-position: center center; background-size: 100% auto; border-spacing: 0px; list-style: outside;"
        />
      </button>

      <div
        id="navbar"
        class="hidden flex-grow items-center xl:flex xl:basis-auto basis-full"
        style="border-spacing: 0px; list-style: outside;"
      >
        <ul
          class="flex flex-col pl-0 my-0 mr-auto xl:flex-row"
          style="list-style: none; border-spacing: 0px;"
        >
          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href=""
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              Association
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/about-proto"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                About Proto
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/board"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Board
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="	https://www.proto.utwente.nl/page/oldfarts"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Previous Boards
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/honorarymembers"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Honorary Members
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/committee/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Committees
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/society/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Societies
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/events"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Calendar
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/news/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                News
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/albums"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Photo Albums
              </a>
            </ul>
          </li>
          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href=""
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              For Members
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/stickers"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Sticker Tracker
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/quotes"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Quote Corner
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/goodideas"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Good Idea Board
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://protu.be"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                ProTube
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/fishcam"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                FishCam
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/proto-song"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Proto Song
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/tokens"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Board Tokens
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/Memberpasses"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Memberpasses
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/achievement/gallery"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Achievements
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/Posterrequest"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Requests
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/mental-health"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Mental Health
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/leaderboards"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Leaderboards
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://omnomcom.nl/"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Omnomcom.nl
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/ldap/search"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                UT Address Book
              </a>
            </ul>
          </li>
          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href=""
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              Education
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/education"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Useful Links
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://wiki.proto.utwente.nl/education/study/start"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Study Material
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/committee/educacie"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                EducaCie
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/onlinesystems"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Online Systems
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="/feedback/educationalfeedbackyear1"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Educational Feedback (Y1)
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/feedback/educationalfeedbackyear2"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Educational Feedback (Y2)
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/feedback/educationalfeedbackyear3"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Educational Feedback (Y3)
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/feedback/educationalfeedbackitech"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Educational Feedback (I-Tech)
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://wo4you.nl/student-association/shop/c138b599-a644-41c0-90d7-7a40e674bd1c"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Books
              </a>
            </ul>
          </li>
          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href=""
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em; transition: none; border-spacing: 0px; list-style: none;"
            >
              Career
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/companies/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Companies
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/joboffers/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Job Offers
              </a>
            </ul>
          </li>
          <li
            class="text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              class="block p-2 text-base font-normal text-white bg-none border-0 cursor-pointer xl:px-2"
              href="https://wiki.proto.utwente.nl/"
              role="button"
              aria-haspopup="false"
              aria-expanded="false"
              style="text-decoration: none; transition: none; border-spacing: 0px; list-style: none;"
            >
              Wiki
            </a>
          </li>
          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href=""
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              Contact
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/contact"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Contact
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page/for-companies"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                For Companies
              </a>
            </ul>
          </li>

          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href="#"
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              OmNomCom
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/store/protopolis"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Open store: Protopolis
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/store/tipcie"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Open store: TIPCie
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/store/alfred"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Open store: Alfred's nook
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/orders"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Orders
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/products"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Products
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/categories"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Categories
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/supplier"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Generate Supplier Order
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/products/statistics"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Sales statistics
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/dinnerform/create"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Dinnerforms
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/tipcie"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                TIPCie Order Overview
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/wallstreet"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Wallstreet Drinks
              </a>
            </ul>
          </li>

          <li
            id="admin-nav-item"
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href="#"
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              Admin
              <span
                class=""
                style="border-spacing: 0px; list-style: none;"
              />
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute xl:overflow-y-auto border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/user/admin/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Users
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/tickets"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Tickets
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/short_urls"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Short URLs
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/queries"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Queries
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/tempadmins"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Temp ProTube Admin
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://protu.be/remote"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                ProTube Admin
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/committee/create"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Add Committee
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/events/create"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Add Event
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/events/categories/create"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Event Categories
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/feedback/categories/admin"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Feedback Categories
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/narrowcasting/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Narrowcasting
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/companies/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Companies
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/joboffers/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Job offers
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/leaderboards/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Leaderboards
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />

              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/events/financial/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Close Activities
              </a>

              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/accounts/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Accounts
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/withdrawals"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Withdrawals
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/unwithdrawable"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Unwithdrawable
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/mollie/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Mollie Payments
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/omnomcom/payments/statistics"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Cash &amp; Card Payments
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/minisites/isalfredthere/edit"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Is Alfred There?
              </a>
            </ul>
          </li>

          <li
            class="relative text-left"
            style="border-spacing: 0px; list-style: none;"
          >
            <a
              href="#"
              class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
              data-bs-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="false"
              style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
            >
              Site
              <span
                class=""
                style="border-spacing: 0px; list-style: none;"
              />
            </a>

            <ul
              class="hidden static py-2 px-0 m-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
              style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
            >
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/menu"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Menu
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/video/admin"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Videos
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/page"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Pages
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/news/admin"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                News
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/email"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Email
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/achievement"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Achievements
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/leaderboards/list"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Leaderboards
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/welcomeMessages"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Welcome Messages
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/news/create?is_weekly=1"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Weekly Update
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/headerimages"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Header Images
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/albums/admin/index"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Photo Admin
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/alias"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Aliases
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/announcement/admin"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Announcements
              </a>
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/authorization"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Authorization
              </a>
              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/codex"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Codices
              </a>

              <li
                role="separator"
                class="overflow-hidden my-2 mx-0 h-0 border-t border-solid opacity-100 border-neutral-300"
                style="border-spacing: 0px; list-style: none;"
              />
              <a
                class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                href="https://www.proto.utwente.nl/passwordstore"
                style="text-decoration: none; border-spacing: 0px; list-style: none;"
              >
                Password Store
              </a>
            </ul>
          </li>
        </ul>

        <form
          method="post"
          action="https://www.proto.utwente.nl/search"
          class="float-right mt-2 mr-2 md:mt-0"
          data-dashlane-rid="be43b57fc738a837"
          style="border-spacing: 0px; list-style: outside;"
        >
          <input
            type="hidden"
            name="_token"
            value="fuJ1RCnfNwyyi8TN3MWZRIgJLl5v2mSCQpj6yqFF"
            autocomplete="off"
            class="m-0 text-black"
            style="border-spacing: 0px; list-style: outside;"
          >
          <div
            class="flex relative flex-wrap items-stretch w-full"
            style="border-spacing: 0px; list-style: outside;"
          >
            <input
              class="block relative flex-auto py-1 px-3 m-0 min-w-0 text-base font-normal leading-normal text-black bg-clip-padding bg-white border border-solid appearance-none cursor-text border-zinc-200 focus:border-lime-200"
              placeholder="Search"
              type="search"
              name="query"
              style="max-width: 125px; outline-offset: -2px; width: 1%; border-radius: 6px 0px 0px 6px; transition: none; border-spacing: 0px; list-style: outside;"
              data-dashlane-rid="b24e652bedc0e0d9"
            >
            <button
              type="submit"
              class="inline-block relative items-center py-1 px-3 m-0 font-sans text-base font-normal text-center text-white normal-case align-middle whitespace-nowrap bg-cyan-500 border border-cyan-500 border-solid cursor-pointer select-none hover:text-white focus:text-white"
              data-dashlane-label="true"
              data-dashlane-rid="a50359296c8136db"
              style="border-radius: 0px 6px 6px 0px; text-decoration: none; transition: none; z-index: 2; border-spacing: 0px; list-style: outside;"
            >
              <i
                class="inline-block w-5 not-italic font-black leading-none"
                style="font-feature-settings: normal; font-synthesis: none; font-variant: normal; text-rendering: auto; content: normal; border-spacing: 0px; list-style: outside;"
              />
            </button>
          </div>
        </form>

        <div
          class="mt-2 md:mt-0"
          style="border-spacing: 0px; list-style: outside;"
        >
          <ul
            class="flex flex-col pl-0 my-0 mr-auto xl:flex-row"
            style="list-style: none; border-spacing: 0px;"
          >
            <li
              class="relative text-left"
              style="border-spacing: 0px; list-style: none;"
            >
              <a
                href="#"
                class="block p-2 ml-0 text-base font-normal text-white whitespace-nowrap bg-none border-0 border-transparent border-solid cursor-pointer xl:px-2"
                data-bs-toggle="dropdown"
                role="button"
                aria-haspopup="true"
                aria-expanded="false"
                style="text-decoration: none; vertical-align: 0.255em;  transition: none; border-spacing: 0px; list-style: none;"
              >
                Menke
                <img
                  id="profile-picture"
                  class="mx-0 -mt-4 -mb-3 w-12 max-w-full h-12 align-middle border-2 border-white border-solid"
                  alt="your profile picture"
                  src="https://www.proto.utwente.nl/images/default-avatars/other.png"
                  style="border-radius: 50%; border-spacing: 0px; list-style: none;"
                >
              </a>

              <div
                class="hidden static py-2 px-0 mx-0 mt-2 mb-0 text-base bg-clip-padding rounded-md border border-solid xl:absolute border-neutral-300 bg-zinc-100"
                style="z-index: 1000; min-width: 160px; list-style: none; border-spacing: 0px;"
              >
                <a
                  class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                  href="https://www.proto.utwente.nl/user/dashboard"
                  style="text-decoration: none; border-spacing: 0px; list-style: none;"
                >
                  Dashboard
                </a>

                <a
                  class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                  href="https://www.proto.utwente.nl/user"
                  style="text-decoration: none; border-spacing: 0px; list-style: none;"
                >
                  My Profile
                </a>

                <a
                  class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                  href="https://www.proto.utwente.nl/albums/liked"
                  style="text-decoration: none; border-spacing: 0px; list-style: none;"
                >
                  My Liked Photos
                </a>

                <a
                  href="https://saproto.nl/go/discord"
                  target="_blank"
                  class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                  style="text-decoration: none; border-spacing: 0px; list-style: none;"
                >
                  <span
                    class="inline-block w-5 not-italic leading-none text-center"
                    style="font-feature-settings: normal; font-synthesis: none; font-variant: normal; text-rendering: auto; content: normal; border-spacing: 0px; list-style: none;"
                  />
                  Discord
                  <span
                    class="inline-block py-1 px-2 text-xs font-bold leading-none text-center text-white align-baseline bg-gray-500 rounded-md"
                    style="transform: translateY(-1px); border-spacing: 0px; list-style: none;"
                  >
                    <i
                      class="inline-block mr-1 w-4 not-italic font-black"
                      style="font-feature-settings: normal; font-synthesis: none; font-variant: normal; text-rendering: auto; content: normal; border-spacing: 0px; list-style: none;"
                    />
                    <span
                      id="discord__online"
                      class="leading-3"
                      style="border-spacing: 0px; list-style: none;"
                    >82</span>
                  </span>
                </a>

                <a
                  class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                  href="https://www.proto.utwente.nl/protube/dashboard"
                  style="text-decoration: none; border-spacing: 0px; list-style: none;"
                >
                  ProTube Dashboard
                </a>
                <a
                  class="block clear-both py-1 px-4 w-full font-normal whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                  href="https://www.proto.utwente.nl/omnomcom/orders/history"
                  style="text-decoration: none; border-spacing: 0px; list-style: none;"
                >
                  Purchase History
                </a>

                <form
                  action="https://www.proto.utwente.nl/logout"
                  method="POST"
                  class=""
                  style="border-spacing: 0px; list-style: none;"
                >
                  <input
                    type="hidden"
                    name="_token"
                    value="fuJ1RCnfNwyyi8TN3MWZRIgJLl5v2mSCQpj6yqFF"
                    autocomplete="off"
                    class="m-0 text-black"
                    style="border-spacing: 0px; list-style: none;"
                  >
                  <button
                    class="block clear-both py-1 px-4 m-0 w-full font-normal normal-case whitespace-nowrap bg-transparent rounded-none border-0 cursor-pointer"
                    type="submit"
                    style="text-decoration: none; border-spacing: 0px; list-style: none;"
                  >
                    Logout
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>