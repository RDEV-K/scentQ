import {sprintf} from "sprintf-js";

export const translate = (translatable, ...args) => sprintf(translatable, ...args)
