<script setup lang="ts">
import { Clock, Heart, House, Mail, Phone, Shield } from 'lucide-vue-next';
import { YouTubeIcon, InspireIcon, InstagramIcon } from 'vue3-simple-icons'
</script>

<template>
  <footer class="py-4 mt-4 leading-6 text-white bg-proto-dark">
    <div class="px-3 mx-auto sm:max-w-xl md:max-w-4xl lg:max-w-6xl 2xl:max-w-7xl">
      <div class="flex flex-row">
        <div class="grow px-3 mt-0">
          <span class="text-center flex">
            <House
              class="w-5"
            />
            <strong>
              &nbsp;&nbsp;
              <a
                class="font-bold underline"
                href="https://www.saproto.nl/"
              >
                <span>S.A. Proto</span>
              </a>
            </strong>
          </span>
          <span>
            <span>Zilverling A230</span>
            <br>
            <span>Drienerlolaan 5</span>
            <br>
            <span>7522NB</span>
            <span>Enschede</span>
            <br>
          </span>
        </div>

        <div class="grow px-3 mt-0">
          <br>
          <span class="text-center flex">
            <Clock
              class="w-4.5"
              fill="white"
            />
            &nbsp;&nbsp;Monday &amp; Friday 08:30-16:00
          </span>
          <span class="text-center flex">
            <Clock
              class="w-4.5"
              fill="white"
            />
            &nbsp;&nbsp;Tuesday-Thursday, 08:30-17:30
          </span>
          <span class="text-center flex text-white">
            <Phone
              class="w-4.5"
              fill="white"
            />
            &nbsp;&nbsp;
            <a
              class="underline"
              href="tel:+31534894423"
            >
              +31 (0)53 489 4423
            </a>
          </span>
          <span class="text-center flex text-white">
            <Mail
              class="w-4.5"
            />
            &nbsp;&nbsp;
            <a
              class="underline"
              href="mailto:board@proto.utwente.nl"
            >
              board@proto.utwente.nl
            </a>
          </span>
        </div>

        <div class="hidden grow px-3 mt-0 text-right lg:block">
          <br>
          <a
            class="underline"
            href="https://www.youtube.com/channel/UCdH2x3ObOrmLdm2OOGDBslw"
            target="_blank"
          >
            YouTube&nbsp;&nbsp;
            <YouTubeIcon
              class="inline-block w-5"
              size="17"
              style="fill: white"
            />
          </a>
          <br>
          <a
            class="underline"
            href="https://www.linkedin.com/company/s-a-proto/"
            target="_blank"
          >
            LinkedIn&nbsp;&nbsp;
            <InspireIcon
              class="inline-block w-5"
              size="16"
              style="fill: white"
            />
          </a>
          <br>
          <a
            class="underline"
            href="https://www.instagram.com/s.a.proto/"
            target="_blank"
          >
            Instagram&nbsp;&nbsp;
            <InstagramIcon
              class="inline-block w-5"
              size="16"
              style="fill: white"
            />
          </a>
          <br>
          <a
            class="underline"
            href="https://www.proto.utwente.nl/page/privacy"
            target="_blank"
          >
            Privacy Policy&nbsp;&nbsp;
            <Shield
              class="inline-block w-5"
              fill="white"
            />
          </a>
          <br>
        </div>

        <div
          class="hidden shrink-0 lg:grow content-center px-3 mt-0 text-right md:block"
        >
          <img
            src="https://www.proto.utwente.nl/images/logo/inverse.png"
            alt="inverse proto logo"
            class="mx-auto h-32"
          >
        </div>
      </div>

      <p
        class="mt-4 mb-2 text-center"
      >
        <sub
          class="relative text-xs align-baseline"
        >
          © 2026 S.A. Proto. All rights reserved.
          <span
            class="sm:hidden"
          >
            Please familiarize yourself with our
            <a
              href="https://wiki.proto.utwente.nl/ict/privacy/start?do=export_pdf"
              target="_blank"
              class="underline"
            >
              privacy policy
            </a>
            and
            <a
              href="https://wiki.proto.utwente.nl/ict/responsible-disclosure"
              target="_blank"
              class="underline"
            >
              responsible disclosure policy
            </a>
            .
          </span>
          The website source is available on
          <a
            href="https://github.com/saproto/saproto"
            target="_blank"
            class="underline"
          >
            GitHub
          </a>
          .
          <br>
          This website has been created with
          <Heart
            class="inline-block w-4 text-proto-primary"
            fill="currentColor"
          />
          by the folks of the
          <a
            href="https://haveyoutriedturningitoffandonagain.nl"
            target="_blank"
            class="underline"
          >
            Have You Tried Turning It Off And On Again committee
          </a>
          .
        </sub>
      </p>
    </div>
  </footer>
</template>
