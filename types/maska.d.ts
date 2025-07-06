// Type definitions for Maska
declare module 'maska' {
  export interface MaskaOptions {
    mask?: string | string[] | ((value: string) => string);
    tokens?: Record<string, RegExp>;
    eager?: boolean;
    reversed?: boolean;
    tokensReplace?: boolean;
    preProcess?: (value: string) => string;
    postProcess?: (value: string) => string;
  }

  export interface MaskaDetail {
    masked: string;
    unmasked: string;
    completed: boolean;
  }

  export interface MaskaEvent extends Event {
    detail: MaskaDetail;
  }

  export function mask(value: string, options: MaskaOptions): MaskaDetail;
  export function unmask(value: string, options: MaskaOptions): string;
  export function masked(value: string, options: MaskaOptions): string;
  export function unmasked(value: string, options: MaskaOptions): string;
}

declare module 'maska/vue' {
  import { DirectiveBinding } from 'vue';
  import { MaskaOptions } from 'maska';

  export const vMaska: {
    created(el: HTMLElement, binding: DirectiveBinding<MaskaOptions>): void;
    updated(el: HTMLElement, binding: DirectiveBinding<MaskaOptions>): void;
    unmounted(el: HTMLElement): void;
  };
}

export {};